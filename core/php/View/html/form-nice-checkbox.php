<div class="<?php echo $view->getHtmlClass(); ?>" <?php echo $view->getDataAtts(); ?> data-input_name="<?php echo $view->get_input_name(); ?>" data-view="<?php echo $view->getName(); ?>">

    <?php if($view->has_title()): ?>
    <label class="title-label"><?php echo $view->get_title(); ?></label>
    <?php endif; ?>

    <?php foreach($view->get_options() as $option): 
        $option_id = $view->get_input_name() . '_' . $option['value'];
        $checked = ($view->has_selected() && in_array($option['value'], $view->get_selected())) ? ' checked' : '';
        $required = $view->has_required() ? ' required' : '';
        ?>
    <div class="nice-checkbox size-<?php echo $view->get_size(); ?>">
        <input type="<?php echo $view->getInputType(); ?>" id="<?php echo $option_id; ?>" name="<?php echo $view->get_input_name(); ?>" value="<?php echo $option['value']; ?>"<?php echo $checked . $required; ?>> 
        <label for="<?php echo $option_id; ?>"><?php echo $option['name']; ?></label>
    </div>
    <?php endforeach; ?>
</div>