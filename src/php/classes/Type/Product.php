<?php 

namespace TILEC\Type;

use TILEC\Utils_Settings;

class Product extends \WPSEED\Post 
{
    var $product;
    var $tile_config;

    public function __construct($post)
    {
        $this->post_type = 'product';
        parent::__construct($post, self::_get_props_config());

        $this->product = wc_get_product($this->get_id());
        $this->tile_config = [];
    }

    static function _get_props_config()
    {
        return [
            'tile_width' => [
                'type' => 'meta',
                'input_sanitize' => 'integer',
                'metabox_id' => 'tilec_product_tile'
            ],
            'tile_height' => [
                'type' => 'meta',
                'input_sanitize' => 'integer',
                'metabox_id' => 'tilec_product_tile'
            ]
        ];
    }

    public function getTileConfig()
    {
        $tile_config = [];

        $tile_height = $this->getTileHeight(true);
        $tile_width = $this->getTileWidth(true);

        for($h=0; $h < $tile_height; $h++)
        {
            $tile_config[$h] = [];
            for($w=0; $w < $tile_width; $w++)
            {
                $tile_config[$h][$w] = 1;
            }
        }

        return $tile_config;
    }

    public function getTileWidth($tiles=false)
    {
        $tile_size = Utils_Settings::getTileSize();
        $tile_width = (int)$this->get_meta('tile_width', true);
        return $tiles ? ceil($tile_width / $tile_size) : $tile_width;
    }

    public function getTileHeight($tiles=false)
    {
        $tile_size = Utils_Settings::getTileSize();
        $tile_height = (int)$this->get_meta('tile_height', true);
        return $tiles ? ceil($tile_height / $tile_size) : $tile_height;
    }
}