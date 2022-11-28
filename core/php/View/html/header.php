<header class="<?php echo $view->getHtmlClass('shad-s1'); ?>" data-view="<?php echo $view->getName(); ?>">
    <?php if($view->has_show_nav_top()): ?>
    <div class="header-r1 d-none d-lg-block">
        <div class="container">
            <nav class="nav-top d-none d-lg-block" role="navigation">
                <?php
                wp_nav_menu(
                    [
                        'theme_location'  => 'top',
                        'container_class' => 'menu-cont',
                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                        'fallback_cb'     => false,
                        'depth' => 1
                    ]
                );
                ?>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    <?php if($view->has_show_nav_primary()): ?>
    <div class="header-r2">
        <div class="container">
            <div class="row">
                <div class="col-6 col-lg-4">
                    <?php if($view->has_logo_html()): ?>
                    <div class="site-logo">
                        <a href="<?php echo home_url(); ?>">
                            <?php echo $view->get_logo_html(); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-6 col-lg-8">
                    <nav class="nav-primary d-none d-lg-block" role="navigation">
                        <?php
                        wp_nav_menu(
                            [
                                'theme_location'  => 'primary',
                                'container_class' => 'menu-cont',
                                'link_before' => '<span class="item-name">',
                                'link_after' => '<span class="item-border"></span></span>',
                                // 'after' => '<span class="item-bg"></span>',
                                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                'fallback_cb'     => false,
                                'depth' => 1
                            ]
                        );
                        ?>
                    </nav>
                    <div class="nav-toggle-cont d-lg-none text-end">
                        <button type="button" class="nav-toggle-btn"></button>
                    </div>
                    <div class="navs-mob-cont d-lg-none">
                        <div class="navs-cont">
                            <nav class="nav-top-mob" role="navigation">
                                <?php
                                wp_nav_menu(
                                    [
                                        'theme_location'  => 'top',
                                        'container_class' => 'menu-cont',
                                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                        'fallback_cb'     => false,
                                        'depth' => 1
                                    ]
                                );
                                ?>
                            </nav>
                            <nav class="nav-primary-mob" role="navigation">
                                <?php
                                wp_nav_menu(
                                    [
                                        'theme_location'  => 'primary',
                                        'container_class' => 'menu-cont',
                                        'link_before' => '<span class="item-name">',
                                        'link_after' => '<span class="item-border"></span></span>',
                                        // 'after' => '<span class="item-bg"></span>',
                                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                        'fallback_cb'     => false,
                                        'depth' => 1
                                    ]
                                );
                                ?>
                            </nav>
                        </div>
                        <div class="nav-close-area d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>
