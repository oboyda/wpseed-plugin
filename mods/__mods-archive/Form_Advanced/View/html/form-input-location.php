<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <input type="text" id="<?php echo $view->get_input_name(); ?>" name="<?php echo $view->get_input_name(); ?>_display" class="input-display" maxlength="100" />
    <input type="hidden" name="<?php echo $view->get_input_name(); ?>" class="input-sys" />
</div>