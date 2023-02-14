<?php

namespace PBOOT\Mod\Post_List\View;

use WPSEEDE\Utils\Type_List as Utils_Type_List;
use WPSEEDE\Utils\Type as Utils_Type;

class Post_List extends \PBOOT\View\View 
{
    const MOD_NAME = 'Post_List';

    public function __construct($args, $args_default=[])
    {
        parent::__construct($args, wp_parse_args($args_default, [
            
            'list_title' => '',

            'items' => null,
            'items_total' => 0,
            'items_per_page' => 2,

            // 'post_type' => 'post',
            'type_class' => '\PBOOT\Type\Post',

            'q_args' => [],
            'action_name' => 'pboot_load_post_list',

            'cols_num' => 2,

            'list_view' => 'Post_List/post-list',
            'list_nofound_view' => 'Post_List/post-list-nofound',
            'list_nofound_text' => __('No items found', 'pboot'),

            'item_view' => 'Post_List/post-list-item',
            'item_args' => [],

            'filters_view' => 'Post_List/post-list-filters-form',
            'filters_args' => [],

            'show_pager' => true,
            'pager_view' => 'Post_List/list-pager',
            'pager_args' => [],

            'set_items' => true
        ]));

        if($this->args['set_items'])
        {
            $this->setItems();
        }
    }

    protected function setItems()
    {
        if(!isset($this->items))
        {
            $this->args['q_args'] = wp_parse_args($this->args['q_args'], [
                'paged' => 1,
                // 'post_type' => $this->args['post_type'],
                'orderby' => 'title',
                'posts_per_page' => $this->args['items_per_page']
            ]);
            $this->args['q_args'] = wp_parse_args(Utils_Type::getTypeRequestArgs($this->args['type_class'], [], true), $this->args['q_args']);
    
            $items = Utils_Type_List::getItems($this->args['q_args'], $this->args['type_class']);

            $this->args['items'] = $items['items'];
            $this->args['items_total'] = $items['items_total'];
        }

        $this->setHtmlParts();
    }

    protected function setHtmlParts()
    {
        $this->args['filters_args'] = wp_parse_args($this->args['filters_args'], [
            'q_args' => $this->args['q_args'],
            'action_name' => $this->args['action_name'],
            'list_view' => $this->args['list_view'],
            'list_view_id' => $this->getId(),
            'list_block_id' => $this->get_block_id()
            // 'list_args' => $this->getArgsExtPublic()
        ]);
        $this->setChildPart('filters_html', pboot_get_view($this->args['filters_view'], $this->args['filters_args']));

        $items_html = '';
        if(!empty($this->args['items']))
        {
            $_items = [];
            foreach($this->get_items() as $item)
            {
                $_items[] = pboot_get_view($this->args['item_view'], wp_parse_args($this->args['item_args'], [
                    // 'type_class' => $this->args['type_class'],
                    'item' => $item
                ]));
            } 
            $items_html = $this->renderItemsCols($_items, $this->args['cols_num'], 'lg');
        }
        elseif($this->args['list_nofound_view'] && $this->args['q_args']['paged'] === 1)
        {
            $items_html = pboot_get_view($this->args['list_nofound_view'], [
                'nofound_text' => $this->args['list_nofound_text']
            ]);
        }
        $this->setChildPart('items_html', $items_html);

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