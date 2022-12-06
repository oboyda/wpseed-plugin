<div class="<?php echo $view->getHtmlClass(); ?>">

    <?php echo $view->getContainerTagOpen(); ?>

    <div class="container">
        <?php 
        if($view->has_status()): 
            pboot_print_view('Status_Message/status-message', [
                'type' => 'success',
                'message' => $view->get_success_message()
            ]);
        else:
            pboot_print_view('Status_Message/status-message', [
                'type' => 'error',
                'message' => $view->get_error_message()
            ]);
        endif;
        ?>

        <?php if($view->has_back_url()): ?>
        <div class="go-back ta-center">
            <a href="<?php echo $view->get_back_url(); ?>" class="app-btn"><?php echo $view->get_back_label(); ?></a>
        </div>
        <?php endif; ?>
    </div>

    <?php echo $view->getContainerTagClose(); ?>
</div>