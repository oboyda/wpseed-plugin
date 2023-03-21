<div class="<?php echo $view->getHtmlClass(); ?>" data-view="<?php echo $view->getName(); ?>">

    <?php $view->openContainer(); ?>

    <div class="switch-contents">
        <div class="switch-content content-login-form<?php if($view->isFormActive('login')) echo ' active'; ?>">

            <h3 class="form-title"><?php _e('Log in', 'pboot'); ?></h3>

            <form class="ajax-form login--form" method="POST">
                <div class="form-block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input">
                                <input type="text" name="user_login" placeholder="<?php _e('User name / Email', 'pboot'); ?>" value="<?php echo $view->getReq('user_login'); ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input">
                                <input type="password" name="user_pass" placeholder="<?php _e('Password', 'pboot'); ?>" required autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-block submit">
                    <button type="submit" class="app-btn w-full"><?php _e('Login', 'pboot'); ?></button>
                </div>
                <div class="form-block remember-recover">
                    <div class="row">
                        <div class="col-6">
                            <div class="nice-checkbox s1">
                                <input type="checkbox" id="remember" name="remember" value="1" checked /> 
                                <label for="remember"><?php _e('Remember me', 'pboot'); ?></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="recover-pass ta-right">
                                <a href="#" class="switch-content-btn" data-content_name="content-resetpass-form"><?php _e('Forgot your password?', 'pboot'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="pboot_user_login" />

                <div class="messages-cont"></div>
            </form>
        </div>
        <div class="switch-content content-resetpass-form<?php if($view->isFormActive('resetpass')) echo ' active'; ?>">

            <h3 class="form-title"><?php _e('Reset password', 'pboot'); ?></h3>

            <form class="ajax-form resetpass-form" method="POST">
                <div class="form-block">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-input">
                                <?php if($view->hasReq('resetpasshash') && $view->hasReq('user_login')): ?>
                                <input type="password" name="user_pass" placeholder="<?php _e('New password', 'pboot'); ?>" required />
                                <input type="hidden" name="user_login" value="<?php echo $view->getReq('user_login'); ?>" />
                                <input type="hidden" name="resetpasshash" value="<?php echo $view->getReq('resetpasshash'); ?>" />
                                <?php else: ?>
                                <input type="text" name="user_login" placeholder="<?php _e('User name / Email', 'pboot'); ?>" required />
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input submit">
                                <button type="submit" class="app-btn w-full"><?php _e('Reset', 'pboot'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!($view->hasReq('resetpasshash') && $view->hasReq('user_login'))): ?>
                <div class="form-block ta-right">
                    <a href="#" class="switch-content-btn" data-content_name="content-login-form"><?php _e('Back to login', 'pboot'); ?></a>
                </div>
                <?php endif; ?>

                <input type="hidden" name="action" value="pboot_resetpass" />

                <div class="messages-cont"></div>
            </form>
        </div>
    </div>

    <?php $view->closeContainer(); ?>

</div>