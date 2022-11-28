<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <?php if($view->has_input_name_from() && $view->has_input_name_till()): ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-input date-from">
                <label for="<?php echo $view->get_input_name_from(); ?>_display"><?php echo $view->get_label_from(); ?></label>
                <input type="text" class="date-input-display date-from-display" name="<?php echo $view->get_input_name_from(); ?>_display" value="" />
                <input type="hidden" class="date-input date-from" name="<?php echo $view->get_input_name_from(); ?>" value="" />
                <div class="datepicker d-none"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-input date-till">
                <label for="<?php echo $view->get_input_name_till(); ?>_display"><?php echo $view->get_label_till(); ?></label>
                <input type="text" class="date-input-display date-till-display" name="<?php echo $view->get_input_name_till(); ?>_display" value="" />
                <input type="hidden" class="date-input date-till" name="<?php echo $view->get_input_name_till(); ?>" value="" />
                <div class="datepicker d-none"></div>
            </div>
        </div>
    </div>
    <?php elseif($view->has_input_name_from()): ?>
    <div class="form-input date-from">
        <label for="<?php echo $view->get_input_name_from(); ?>_display"><?php echo $view->get_label_from(); ?></label>
        <input type="text" class="date-input-display date-from-display" name="<?php echo $view->get_input_name_from(); ?>_display" value="" />
        <input type="hidden" class="date-input date-from" name="<?php echo $view->get_input_name_from(); ?>" value="" />
        <div class="datepicker d-none"></div>
    </div>
    <?php elseif($view->has_input_name_till()): ?>
    <div class="form-input date-till">
        <label for="<?php echo $view->get_input_name_till(); ?>_display"><?php echo $view->get_label_till(); ?></label>
        <input type="text" class="date-input-display date-till-display" name="<?php echo $view->get_input_name_till(); ?>_display" value="" />
        <input type="hidden" class="date-input date-till" name="<?php echo $view->get_input_name_till(); ?>" value="" />
        <div class="datepicker d-none"></div>
    </div>
    <?php endif; ?>
</div>