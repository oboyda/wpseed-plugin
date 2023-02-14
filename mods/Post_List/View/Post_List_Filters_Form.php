<?php

namespace PBOOT\Mod\Post_List\View;

use WPSEED\Req;
use WPSEEDE\Utils\Base as Utils_Base;

class Post_List_Filters_Form extends \PBOOT\View\View 
{
    const MOD_NAME = 'Post_List';

    protected $req;

    public function __construct($args, $default_args=[])
    {
        $this->req = new Req();

        parent::__construct($args, wp_parse_args($default_args, [
            
            'q_args' => [],
            
            'action_name' => 'pboot_load_post_list',

            'list_view' => '',
            'list_block_id' => ''
            // 'list_args' => []
        ]));
        $this->saveViewArgs($args);

        $this->filterListArgs();
    }

    public function getQueryArg($name, $default=null)
    {
        $req_arg = $this->req->get($name);
        $q_arg = isset($req_arg) ? $req_arg : (isset($this->args['q_args'][$name]) ? $this->args['q_args'][$name] : null);

        return (empty($q_arg) && isset($default)) ? $default : $q_arg;
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

    public function printFormRequiredFields()
    {
    ?>
        <input type="hidden" name="list_view" value="<?php echo $this->get_list_view(); ?>" />
        <input type="hidden" name="list_view_id" value="<?php echo $this->get_list_view_id(); ?>" />
        <input type="hidden" name="list_block_id" value="<?php echo $this->get_list_block_id(); ?>" />
        <!-- <input type="hidden" name="list_args" value='<?php //echo serialize($this->get_list_args()); ?>' /> -->
        <input type="hidden" name="paged" class="change-submit" value="<?php echo $this->getQueryArg('paged', 1); ?>" />
        <input type="hidden" name="post_id" value="<?php echo $this->getPostId(); ?>" />
        <input type="hidden" name="action" value="<?php echo $this->get_action_name(); ?>" />
    <?php 
    }
}