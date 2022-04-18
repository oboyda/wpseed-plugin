<?php 

namespace TILEC;

use TILEC\Type\Product;

class Utils_Product 
{
    static function getProducts($args=[])
    {
        $args = wp_parse_args($args, [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_query' => [],
            'tax_query' => []
        ]);
        $args['meta_query'] = array_merge($args['meta_query'], [
            [
                'key' => 'tile_width',
                'compare' => 'EXISTS'
            ],
            [
                'key' => 'tile_height',
                'compare' => 'EXISTS'
            ]
        ]);

        if(count($args['meta_query']) > 1)
        {
            $args['meta_query']['relation'] = 'AND';
        }
        if(count($args['tax_query']) > 1)
        {
            $args['tax_query']['relation'] = 'AND';
        }

        $q = new \WP_Query($args);

        $products = [];
        foreach($q->posts as $post)
        {
            $products[] = new Product($post);
        }

        return [
            'items' => $products,
            'items_total' => $q->found_posts
        ];
    }

    static function getProductsTileConfig()
    {
        $tiles_config = [];

        $products = self::getProducts();

        foreach($products['items'] as $product)
        {
            $tile_config = $product->getTileConfig();
            if($tile_config)
            {
                $tiles_config['product-' . $product->get_id()] = [
                    'product_id' => $product->get_id(),
                    'tile_width' => $product->getTileWidth(),
                    'tile_height' => $product->getTileHeight(),
                    'tile_size_formatted' => $product->getTileWidth() . 'x' . $product->getTileHeight(),
                    'tile_config' => $tile_config
                ];
            }
        }

        return $tiles_config;
    }
}
