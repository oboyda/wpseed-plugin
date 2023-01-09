<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <div class="drop-area d-none d-lg-block">
        <div class="drop-label"><?php echo $view->get_drop_label(); ?></div>
        <div class="drop-summary"></div>
        <div class="input-file">
            <input type="file" name="<?php echo $view->getInputName(); ?>" class="app-btn bc-grey5"<?php if($view->has_multiple()) echo ' multiple="true"'; ?> />
        </div>
        <div class="clear-file">
            <span class="clear-btn">
                <i class="bi bi-x-circle"></i>
                <?php _e('Clear files', 'pboot'); ?>
            </span>
        </div>
    </div>
</div>