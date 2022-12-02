<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo $view->get_title(); ?></h3>
                    <button type="button" class="app-btn icon-only bc-grey4 c-white size-small close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <?php if($view->has_body_content()): ?>
                <div class="modal-body">
                    <div class="body-content">
                        <?php echo $view->get_body_content(); ?>
                    </div>
                    <?php pboot_print_view('Site_Loader/site-loader'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>