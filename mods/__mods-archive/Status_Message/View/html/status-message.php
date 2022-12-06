<div class="<?php echo $view->getHtmlClass(); ?>">
    <?php if($view->has_message()): ?>
    <div class="message message-<?php echo $view->get_type(); ?>"><?php echo wpautop($view->get_message()); ?></div>
    <?php endif; ?>
</div>
