<footer class="<?php echo $view->getHtmlClass(); ?>">

    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <?php 
                            if(is_active_sidebar('footer-widgets-1')):
                                dynamic_sidebar('footer-widgets-1');
                            endif;
                            ?>
                        </div>
                        <div class="col-6">
                            <?php 
                            if(is_active_sidebar('footer-widgets-2')):
                                dynamic_sidebar('footer-widgets-2');
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <?php 
                            if(is_active_sidebar('footer-widgets-3')):
                                dynamic_sidebar('footer-widgets-3');
                            endif;
                            ?>
                        </div>
                        <div class="col-12 col-lg-6">
                            <?php if($view->has_logo_html()): ?>
                            <div class="site-logo">
                                <a href="<?php echo home_url(); ?>">
                                    <?php echo $view->get_logo_html(); ?>
                                </a>
                            </div>
                            <?php endif; ?>

                            <?php if($view->has_copy_info()): ?>
                            <div class="copy-info">
                                <?php echo wpautop($view->get_copy_info()); ?>
                            </div>
                            <?php endif; ?>

                            <?php 
                            // if(is_active_sidebar('footer-widgets-4')):
                            //     dynamic_sidebar('footer-widgets-4');
                            // endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($view->getImplodedFooterInfo()): ?>
    <div class="footer-info">
        <?php echo $view->getImplodedFooterInfo(); ?>
    </div>
    <?php endif; ?>

</footer>