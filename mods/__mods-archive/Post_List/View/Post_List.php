<?php

namespace PBOOT\Mod\Post_List\View;

use WPSEEDE\Utils\Type_List;

class Post_List extends \PBOOT\View\View 
{
    public function __construct($args, $default_args=[])
    {
        $default_args = wp_parse_args($default_args, [
            
            'list_title' => '',

            'items' => null,
            'items_total' => 0,
            'items_per_page' => 2,

            'post_type' => 'post',
            'type_class' => '\PBOOT\Type\Post',

            'q_args' => [],
            'action_name' => 'pboot_load_post_list',

            'cols_num' => 2,

            'list_view' => 'Post_List/post-list',

            'item_view' => 'Post_List/post-list-item',
            'item_args' => [],

            'filters_view' => 'Post_List/list-filters-hidden',
            'filters_args' => [],

            'show_pager' => true,
            'pager_view' => 'Post_List/list-pager',
            'pager_args' => [],

            'set_items' => true
        ]);
        
        parent::__construct($args, $default_args);

        if($this->args['set_items'])
        {
            $this->setItems();
        }

        // if($this->args['post_type'] == 'product')
        // {
        //     file_put_contents(ABSPATH . '/__debug.txt', print_r([
        //         time(),
        //         $this->args
        //     ], true));
        // }
    }

    protected function setItems()
    {
        if(!isset($this->items))
        {
            $this->args['q_args'] = wp_parse_args($this->args['q_args'], [
                'paged' => 1,
                'post_type' => $this->args['post_type'],
                'orderby' => 'title',
                'posts_per_page' => $this->args['items_per_page']
            ]);
    
            $items = Type_List::getItems($this->args['q_args'], $this->args['type_class']);

            $this->args['items'] = $items['items'];
            $this->args['items_total'] = $items['items_total'];
        }

        $this->setHtmlParts();
    }

    protected function setHtmlParts()
    {
        $this->args['filters_args'] = wp_parse_args($this->args['filters_args'], [
            'paged' => $this->args['q_args']['paged'],
            'action_name' => $this->args['action_name'],
            'list_view' => $this->args['list_view'],
            'list_args' => $this->orig_args
        ]);
        $this->setChildPart('filters_html', pboot_get_view($this->args['filters_view'], $this->args['filters_args']));

        $items_html = [];
        foreach($this->get_items() as $item)
        {
            $items_html[] = pboot_get_view($this->args['item_view'], wp_parse_args($this->args['item_args'], [
                'type_class' => $this->args['type_class'],
                'item' => $item
            ]));
        } 
        $this->setChildPart('items_html', $this->renderItemsCols($items_html, $this->args['cols_num'], 'lg'));

        if($this->args['show_pager'])
        {
            $this->args['pager_args'] = wp_parse_args($this->args['pager_args'], [
                'pages_visible' => 5,
                'ajax_pager' => true,
                'items_total' => $this->args['items_total'],
                'items_per_page' => $this->args['items_per_page'],
                'paged' => isset($this->args['q_args']['paged']) ? $this->args['q_args']['paged'] : 1
            ]);
            $this->setChildPart('pager_html', pboot_get_view($this->args['pager_view'], $this->args['pager_args']));
        }
    }
}
