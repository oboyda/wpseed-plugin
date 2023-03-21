<?php 

namespace PBOOT\Mod\User_Login\Action;

use PBOOT\Mod\User_Login\Utils\User as Utils_User;
use PBOOT\Mod\Action_Email\Utils\Email as Utils_Email;
use PBOOT\Type\User as Type_User;
use PBOOT\Utils\Base as Utils_Base;

class User extends \WPSEED\Action 
{
    function __construct()
    {
        parent::__construct();

        add_action('wp_ajax_nopriv_pboot_user_login', [$this, 'login']);

        add_action('wp_ajax_nopriv_pboot_resetpass', [$this, 'resetPass']);

        // add_filter('login_url', [$this, 'filterLoginUrl']);
        // add_action('admin_init', [$this, 'restrictWpAdminAccess']);

        add_action('user_register', [$this, 'sendUserVerificationEmailUserRegister'], 20, 2);

        // add_action('wp_ajax_pboot_resend_verif_email', [$this, 'sendUserVerificationEmail']);
        // add_action('wp_ajax_nopriv_pboot_resend_verif_email', [$this, 'sendUserVerificationEmail']);
    }

    public function login()
    {
        $inputs = [
            'user_login' => $this->getReq('user_login'),
            'user_pass' => $this->getReq('user_pass'),
            'remember' => (bool)$this->getReq('remember'),
            'redirect' => $this->getReq('redirect')
        ];

        $this->checkErrorFields($inputs, [
            'user_login',
            'user_pass'
        ], true);

        if(is_user_logged_in())
        {
            wp_logout();
        }

        $signon_user = wp_signon([
            'user_login' => $inputs['user_login'],
            'user_password' => $inputs['user_pass'],
            'remember' => $inputs['remember']
        ]);

        if(is_wp_error($signon_user))
        {
            $this->addErrorField(['user_login', 'user_pass']);
            // $this->addErrorMessage($signon_user->get_error_message());
            $this->addErrorMessage(apply_filters('pboot_user_login_failed_message', __('Failed to log in. Please, check your credentials.', 'pboot')));
            $this->respond();
        }
        elseif(is_a($signon_user, 'WP_User'))
        {
            $this->checkUserExistsAndVerified($inputs['user_login']);

            if($inputs['redirect'] === '1'){
                $inputs['redirect'] = admin_url();
            }
            if($inputs['redirect']){
                $this->setRedirect(apply_filters('pboot_user_login_success_redirect', $inputs['redirect']));
            }
        }

        if($this->status)
        {
            $this->addSuccessMessage(apply_filters('pboot_user_login_success_message', __('Logged in successfully. Redirecting...', 'pboot')));
        }

        $this->respond();
    }

    public function resetPass()
    {
        $inputs = [
            'user_login' => $this->getReq('user_login'),
            'user_pass' => $this->getReq('user_pass'),
            'resetpasshash' => $this->getReq('resetpasshash')
        ];

        $this->checkErrorFields($inputs, [
            'user_login'
        ], true);

        $type_user = new Type_User($inputs['user_login']);

        $this->checkUserExistsAndVerified($type_user);

        if($inputs['resetpasshash'])
        {
            if(empty($inputs['user_pass']) || !Utils_User::checkPasswordStrength($inputs['user_pass']))
            {
                $this->addErrorField('user_pass');
                $this->respond();
            }

            $error_message = apply_filters('pboot_user_login_passreset_error_message', sprintf(__('An error occurred while resetting the password. Please, <a href="%s">try again later</a>.', 'pboot'), get_site_url()));
            $hash_validated = Utils_User::validateHash($inputs['user_login'], $inputs['resetpasshash'], true);

            if($hash_validated)
            {
                $user_updated = wp_update_user([
                    'ID' => $type_user->get_id(),
                    'user_pass' => $inputs['user_pass']
                ]);

                if(is_wp_error($user_updated))
                {
                    $this->addErrorMessage($error_message);
                    $this->respond();
                }
                
                wp_clear_auth_cookie();

                $this->addSuccessMessage(apply_filters('pboot_user_login_passreset_success_message', __('Password has been reset successfully.', 'pboot')));

                $this->setRedirect(apply_filters('pboot_user_login_resetpass_redirect', add_query_arg(
                    'user_login', 
                    $inputs['user_login'], 
                    wp_login_url()
                )));
            }
            else{
                $this->addErrorMessage($error_message);
            }
        }
        else{
            $hash = Utils_User::addHash($inputs['user_login']);

            $resetpass_url = apply_filters('pboot_user_login_resetpass_url', add_query_arg([
                'user_login' => $inputs['user_login'],
                'resetpasshash' => $hash
            ], wp_login_url()));
    
            $sent = Utils_Email::sendEmailByAction(
                $type_user->getEmail(),
                'resetpass',
                [
                    '%email%' => $type_user->getEmail(),
                    '%resetpass_url%' => $resetpass_url
                ]
            );

            $this->setStatus($sent);

            if($sent)
            {
                $this->addSuccessMessage(apply_filters('pboot_user_login_passreset_email_sent_message', __('Please, check your email to reset the password.', 'pboot')));
            }
            else{
                $this->addErrorMessage(apply_filters('pboot_user_login_passreset_email_failed_message', __('Failed to send password reset email. Please, try again later.', 'pboot')));
            }
        }

        $this->respond();
    }

    public function sendUserVerificationEmailUserRegister($user_id, $userdata=[])
    {
        $type_user = new Type_User($user_id);

        if(!$type_user->isEmailVerified())
        {
            $is_by_admin = current_user_can('manage_options');

            $placeholders = [
                '%user_pass%' => ($is_by_admin && isset($userdata['user_pass'])) ? $userdata['user_pass'] : __('Contraseña elegida', 'pboot')
            ];

            Utils_User::sendVerificationEmail($user_id, $placeholders);
        }
    }

    public function sendUserVerificationEmail()
    {
        $inputs = [
            'user_login' => $this->getReq('user_login')
        ];

        $this->checkErrorFields($inputs, [
            'user_login'
        ], true);

        $type_user = new Type_User($inputs['user_login']);

        if(!$type_user->isEmailVerified())
        {
            $sent = Utils_User::sendVerificationEmail($type_user);

            $this->setStatus($sent);

            if($sent)
            {
                $this->addSuccessMessage(apply_filters('pboot_user_login_verif_email_sent_message', __('Verification email sent successfully. Please, check your email box.', 'pboot')));
            }
            else{
                $this->addErrorMessage(apply_filters('pboot_user_login_verif_email_failed_message', __('Failed to send verification email. Please, try again later.', 'pboot')));
            }
        }

        $this->respond();
    }

    public function filterLoginUrl($login_url)
    {
        $login_url = home_url();
        return $login_url;
    }

    public function restrictWpAdminAccess()
    {
        $restrict_wp_admin = apply_filters('pboot_user_login_restrict_wp_admin', (
            is_admin() 
            && !current_user_can('manage_options') 
            && !wp_doing_ajax()
        ));

        if($restrict_wp_admin){
            wp_redirect(home_url()); 
            exit;
        }
    }

    protected function checkUserExistsAndVerified($user, $respond=true)
    {
        if(!is_a($user, '\PBOOT\Type\User'))
        {
            $user = new Type_User($user);
        }

        if(!$user->get_id())
        {
            if($respond)
            {
                $this->setStatus(false);
                $this->addErrorMessage(__('User not valid.', 'pboot'));
                $this->respond();
            }
            return false;
        }

        if(Utils_User::emailVerificationEnabled() && !$user->isEmailVerified())
        {
            if($respond)
            {
                $this->setStatus(false);
                $this->addErrorMessage(apply_filters('pboot_user_login_verif_email_message', __('Email not verified. <a href="#" class="resend-email-verif" data-user_email="' . $user->getEmail() . '">Resend</a> verification email.', 'pboot')));
                $this->respond();
            }
            return false;
        }

        return true;
    }
}