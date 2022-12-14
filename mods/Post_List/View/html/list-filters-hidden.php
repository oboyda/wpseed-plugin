<div class="<?php echo $view->getHtmlClass('d-none'); ?>">
    <form class="ajax-form filters-form" action="" method="POST">
        <input type="hidden" name="list_view" value="<?php echo $view->get_list_view(); ?>" />
        <input type="hidden" name="list_args" value='<?php echo serialize($view->get_list_args()); ?>' />
        <input type="hidden" name="paged" class="change-submit" value="<?php echo $view->get_paged(); ?>" />
        <input type="hidden" name="post_id" class="change-submit" value="<?php echo $view->getPostId(); ?>" />
        <input type="hidden" name="action" value="<?php echo $view->get_action_name(); ?>" />
    </form>
</div>