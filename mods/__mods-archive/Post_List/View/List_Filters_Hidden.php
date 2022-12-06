<?php

namespace PBOOT\Mod\Post_List\View;

use WPSEEDE\Utils\Base as Utils_Base;

class List_Filters_Hidden extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'paged' => 1,
            'action_name' => 'pboot_load_post_list',

            'list_view' => '',
            'list_args' => []
        ]);

        $this->filterListArgs();
    }

    protected function filterListArgs()
    {
        if(isset($this->args['list_args']['items']))
        {
            unset($this->args['list_args']['items']);
        }
        if(isset($this->args['list_args']['block_data']))
        {
            unset($this->args['list_args']['block_data']);
        }
    }

    public function getPostId()
    {
        return Utils_Base::getGlobalPostId();
    }
}
