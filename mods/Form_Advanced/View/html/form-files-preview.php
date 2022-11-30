<div class="<?php echo $view->getHtmlClass(); ?>">
    <?php 
    if($view->has_items_html()):
        echo $view->distributeCols($view->get_items_html());
    endif;
    ?>
</div>