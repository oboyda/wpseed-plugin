<?php 

namespace PBOOT\Mod\Post_List\Action;

use \WPSEEDE\Utils\Type as Utils_Type;
use \WPSEEDE\Utils\Type_List as Utils_Type_List;

class Post_List extends \WPSEED\Action 
{
    public function __construct()
    {
        parent::__construct();

        add_action('wp_ajax_pboot_load_post_list', [$this, 'loadPostList']);
        add_action('wp_ajax_nopriv_pboot_load_post_list', [$this, 'loadPostList']);
    }

    public function loadPostList()
    {
        $view_name = $this->getReq('list_view', 'text', 'Post_List/post-list');
        $view_args = maybe_unserialize(stripslashes($this->getReq('list_args', 'text', [])));
        $view_args = wp_parse_args($view_args, [
            'q_args' => []
        ]);
        $view_args['q_args']['paged'] = $this->getReq('paged', 'integer', 1);

        $view = pboot_get_view_object($view_name, $view_args);

        if(isset($view) && method_exists($view, 'getChildParts'))
        {
            $this->setValue('view_parts_html', $view->getChildParts());
        }

        $this->respond();
    }
}
