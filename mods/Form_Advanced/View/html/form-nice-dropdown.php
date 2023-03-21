<div class="<?php echo $view->getHtmlClass('advanced-input'); ?>" <?php echo $view->getDataAtts(); ?> data-input_name="<?php echo $view->get_input_name(); ?>" data-view="<?php echo $view->getName(); ?>">
    <?php 
    $elem_class = ['selected-label'];
    if($view->has_label()) $elem_class[] = 'has-label';
    if($view->has_update_label()) $elem_class[] = 'update-label';
    ?>
    <div class="<?php echo implode(' ', $elem_class); ?>">
        <span class="label-clear"></span>
        <span class="label-text" data-orig="<?php echo $view->get_label(); ?>">
            <?php echo $view->get_label(); ?>
        </span>
        <span class="label-toggle"></span>
    </div>
    <div class="dropdown-options">
        <ul>
            <?php 
            $input_name = ($view->has_input_name() && $view->getInputType() === 'checkbox') ? $view->get_input_name() . '[]' : $view->get_input_name();
            $disabled = $view->has_disabled() ? ' disabled' : '';
            
            if($view->getInputType() == 'radio' && $view->has_empty_name()): ?>
                <li class="no-option type-<?php echo $view->getInputType(); ?>">
                    <?php if($input_name): ?>
                    <input type="<?php echo $view->getInputType(); ?>" id="<?php echo $input_name . '_all'; ?>" class="user-input<?php if($view->has_change_submit()) echo ' change-submit'; ?>" name="<?php echo $input_name; ?>" value="" <?php echo $view->getInputDataAtts(); echo $disabled; ?> />
                    <label for="<?php echo $input_name . '_all'; ?>" data-text="<?php echo $view->get_empty_name(); ?>">
                        <span class="label-text"><?php echo $view->get_empty_name(); ?></span>
                    </label>
                    <?php else: ?>
                    <label data-text="<?php echo $view->get_empty_name(); ?>">
                        <span class="label-text"><?php echo $view->get_empty_name(); ?></span>
                    </label>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

            <?php
            foreach($view->get_options() as $i => $option): 
                $elem_class = [];
                if($option['url'])
                {
                    $elem_class[] = 'type-link';
                    if($option['url'] == $view->get_selected())
                    {
                        $elem_class[] = 'active';
                    }
                }
                elseif($option['value']){
                    $elem_class[] = 'type-input';
                    $elem_class[] = 'type-' . $view->getInputType();
                    $elem_class[] = 'value-' . $option['value'];
                }
                ?>
            <li class="<?php echo implode(' ', $elem_class); ?>">

                <?php if($option['url']): ?>
                
                <label data-text="<?php echo $option['name']; ?>">
                    <a href="<?php echo $option['url']; ?>" class="label-text" target="<?php echo $option['target']; ?>"><?php echo $option['name']; ?></a>
                </label>

                <?php 
                else: 
                    $option_id = $view->get_input_id_pref() . $input_name . '_' . $option['value'];
                    $selected = $view->get_selected();
                    $checked = ($option['value'] && ((is_array($selected) && in_array($option['value'], $selected)) || ($option['value'] == $selected))) ? ' checked' : '';
                    ?>

                <input type="<?php echo $view->getInputType(); ?>" id="<?php echo $option_id; ?>" class="user-input<?php if($view->has_change_submit()) echo ' change-submit'; ?>" name="<?php echo $input_name; ?>" value="<?php echo $option['value']; ?>" <?php echo $view->getInputDataAtts(); echo $disabled; echo $checked; ?> />
                <label for="<?php echo $option_id; ?>" data-text="<?php echo $option['name']; ?>">
                    <span class="label-text"><?php echo $option['name']; ?></span>
                </label>

                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="dropdown-area"></div>
</div>