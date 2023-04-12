<div id="<?php echo $view->getId(); ?>" class="<?php echo $view->getHtmlClass('advanced-input'); ?>" data-view="<?php echo $view->getName(); ?>">
    <div class="drop-area">
        <?php if($view->has_drop_label()): ?>
        <div class="drop-label"><?php echo $view->get_drop_label(); ?></div>
        <?php endif; ?>
        <div class="drop-summary"></div>
        <div class="clear-file">
            <span class="clear-btn">
                <i class="bi bi-x-circle"></i>
                <?php _e('Clear files', 'pboot'); ?>
            </span>
        </div>
        <div class="input-file">
            <input type="file" id="<?php echo $view->getId() . '-' . $view->getInputName(); ?>" name="<?php echo $view->getInputName(); ?>" class="<?php echo $view->get_input_class(); ?>"<?php if($view->has_multiple()) echo ' multiple="true"'; ?> />
            <?php if($view->has_input_label()): ?>
            <label for="<?php echo $view->getId() . '-' . $view->getInputName(); ?>" class="<?php echo $view->get_label_class(); ?>"><?php echo $view->get_input_label(); ?></label>
            <?php endif; ?>
        </div>
    </div>
</div>