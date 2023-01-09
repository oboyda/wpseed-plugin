<div class="<?php echo $view->getHtmlClass(); ?>">

    <?php if($view->has_show_icon()): ?>
    <div class="status-icon">
        <i class="<?php echo $view->get_icon_class(); ?>"></i>
    </div>
    <?php endif; ?>

    <?php if($view->has_message()): ?>
    <div class="message"><?php echo wpautop($view->get_message()); ?></div>
    <?php endif; ?>

</div>