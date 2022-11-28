<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">

    <?php $view->openContainer(); ?>

    <div class="login-opts">
        <div class="switch-contents">
            <div class="switch-content content-login-form active">

                <h3 class="form-title"><?php _e('Log in', 'pboot'); ?></h3>

                <form class="ajax-form-std login--form" method="POST">
                    <div class="form-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input type="text" name="login" placeholder="<?php _e('Email', 'pboot'); ?>" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input type="password" name="password" placeholder="<?php _e('Password', 'pboot'); ?>" required autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block submit">
                        <button type="submit" class="app-btn bc-red1 w-full"><?php _e('Login', 'pboot'); ?></button>
                    </div>
                    <div class="form-block remember-recover">
                        <div class="row">
                            <div class="col-6">
                                <div class="nice-checkbox s1">
                                    <input type="checkbox" id="remember" name="remember" value="1" checked /> 
                                    <label for="remember""><?php _e('Remember me', 'pboot'); ?></label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="recover-pass ta-right">
                                    <a href="#" class="switch-content-btn" data-content_name="content-resetpass-form"><?php _e('Forgot your password?', 'pboot'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="user_login" />

                    <div class="messages-cont"></div>
                </form>
            </div>
            <div class="switch-content content-resetpass-form">

                <h3 class="form-title"><?php _e('Reset password', 'pboot'); ?></h3>

                <form class="ajax-form-std resetpass-form" method="POST">
                    <div class="form-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-input">
                                    <input type="text" name="resetpass_email" placeholder="<?php _e('Email', 'pboot'); ?>" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input submit">
                                    <button type="submit" class="app-btn bc-red1 w-full"><?php _e('Reset', 'pboot'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block ta-right">
                        <a href="#" class="switch-content-btn" data-content_name="content-login-form"><?php _e('Back to login', 'pboot'); ?></a>
                    </div>

                    <input type="hidden" name="action" value="resetpass" />

                    <div class="messages-cont"></div>
                </form>
            </div>
        </div>
    </div>

    <?php $view->closeContainer(); ?>

</div>