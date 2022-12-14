<div class="<?php echo $view->getHtmlClass(); ?>" <?php echo $view->getDataAtts(); ?> data-input_name="<?php echo $view->get_input_name(); ?>" data-view="<?php echo $view->getName(); ?>">

    <?php if($view->has_title()): ?>
    <label class="title-label"><?php echo $view->get_title(); ?></label>
    <?php endif; ?>

    <?php 
    foreach($view->get_options() as $option): 

        $option_id = $view->get_input_name() . '_' . $option['value'];
        $checked = ($view->has_selected() && in_array($option['value'], $view->get_selected())) ? ' checked' : '';
        $required = $view->has_required() ? ' required' : '';
        $has_icon = (!empty($option['icon_html']) || !empty($option['icon_class']));
        $checkbox_pos = $has_icon  ? 'right' : $view->get_checkbox_pos();

        $classes = [
            'nice-checkbox',
            'size-' . $view->get_size(),
            'pos-' . $checkbox_pos,
            'value-' . $option['value']
        ];
        if($has_icon)
        {
            $classes[] = 'has-icon';
        }
        ?>
    <div class="<?php echo implode(' ', $classes); ?>">
        <input type="<?php echo $view->getInputType(); ?>" id="<?php echo $option_id; ?>" name="<?php echo $view->get_input_name(); ?>" value="<?php echo $option['value']; ?>"<?php echo $checked . $required; ?>> 
        <label for="<?php echo $option_id; ?>">
            <?php if(!empty($option['icon_html'])): ?>
            <span class="label-icon"><?php echo $option['icon_html']; ?></span>
            <?php endif; ?>
            <?php if(!empty($option['icon_class'])): ?>
            <span class="label-icon"><i class="<?php echo $option['icon_class']; ?>"></i></span>
            <?php endif; ?>
            <span class="label-text"><?php echo $option['name']; ?></span>
        </label>
    </div>
    <?php endforeach; ?>
</div>