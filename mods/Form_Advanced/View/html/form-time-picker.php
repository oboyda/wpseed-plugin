<div class="<?php echo $view->getHtmlClass('advanced-input'); ?>" data-view="<?php echo $view->getName(); ?>">
    <?php if($view->has_label()): ?>
    <label><?php echo $view->get_label(); ?></label>
    <?php endif; ?>
    <div class="t-opts">
        <?php 
        $opts = $view->getOptions();
        $opts_count = count($opts);
        foreach($view->getOptions() as $i => $opt): 
            $is_last = (($i+1) === $opts_count);
            ?>
        <div class="t-opt t-<?php echo str_replace(':', '-', $opt); ?>">
            <button type="button" class="app-btn opt-btn" data-i="<?php echo $i; ?>" data-opt="<?php echo $opt; ?>"><?php echo $opt; ?></button>
            <?php if($view->has_ranges() && !$is_last): ?>
            <button type="button" class="app-btn icon-only range-btn" data-i="<?php echo $i; ?>" data-opt="<?php echo $opt; ?>"><i class="bi bi-chevron-compact-right"></i></button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if($view->has_input_name()): ?>
    <input type="hidden" class="val-input" name="<?php echo $view->get_input_name(); ?>" value="<?php echo $view->get_value(); ?>" />
    <?php endif; ?>
</div>