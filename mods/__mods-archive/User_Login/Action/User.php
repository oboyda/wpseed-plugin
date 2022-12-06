<?php 

namespace PBOOT\Mod\User_Login\Action;

use PBOOT\Mod\User_Login\Utils\User as Utils_User;
use PBOOT\Mod\User_Login\Utils\Email as Utils_Email;
use PBOOT\Type\User as Type_User;
use PBOOT\Utils\Base as Utils_Base;

class User extends \WPSEED\Action 
{
    function __construct()
    {
        parent::__construct();

        add_action('wp_ajax_nopriv_user_login', [$this, 'login']);
        add_action('wp_ajax_nopriv_resetpass', [$this, 'resetPass']);

        add_filter('login_url', [$this, 'filterLoginUrl']);
        add_action('admin_init', [$this, 'restrictWpAdminAccess']);

        add_action('user_register', [$this, 'sendUserVerificationEmailUserRegister'], 20, 2);
        add_action('wp_ajax_nopriv_resend_verif_email', [$this, 'sendUserVerificationEmail']);
    }

    public function login()
    {
        $inputs = [
            'login' => $this->getReq('login'),
            'password' => $this->getReq('password'),
            'remember' => (bool)$this->getReq('remember', false),
        ];

        $this->checkErrorFields($inputs, [
            'login',
            'password'
        ], true);

        $signon_user = wp_signon([
            'user_login' => $inputs['login'],
            'user_password' => $inputs['password'],
            'remember' => $inputs['remember']
        ]);

        if(is_wp_error($signon_user))
        {
            $this->setStatus(false);
            $this->addErrorMessage($signon_user->get_error_message());
        }
        elseif(is_a($signon_user, 'WP_User'))
        {
            $this->checkUserExistsAndVerified($inputs['user_login'], $resp);
    
            $this->setStatus(true);
            $this->setRedirect(admin_url());
        }

        if(!$this->hasErrors())
        {
            $this->addSuccessMessage(__('Logged in successfully. Redirecting...', 'pboot'));
        }

        $this->respond();
    }

    static function resetPass()
    {
        $inputs = [
            'user_login' => $this->getReq('user_login'),
            'user_password' => $this->getReq('user_password'),
            'resetpasshash' => $this->getReq('resetpasshash')
        ];

        $this->checkErrorFields($inputs, [
            'user_login'
        ], true);

        $this->checkUserExistsAndVerified($inputs['user_login'], $resp);

        if($inputs['resetpasshash'])
        {
            if(!Utils_User::checkPasswordStrength($inputs['user_password']))
            {
                $this->addErrorField('user_password');
            }

            $type_user = new Type_User($inputs['user_login']);

            $error_message = sprintf(__('An error occurred while resetting the password. Please, <a href="%s">try again later</a>.', 'pboot'), get_site_url());
            $hash_validated = Utils_User::validateHash($inputs['user_login'], $inputs['resetpasshash'], true);

            if($hash_validated)
            {
                $user_updated = wp_update_user([
                    'ID' => $type_user->getId(),
                    'user_pass' => $inputs['user_password']
                ]);

                if(is_wp_error($user_updated))
                {
                    $this->addErrorMessage($error_message);
                    $this->respond();
                }
                
                wp_clear_auth_cookie();

                $this->addSuccessMessage(__('Password has been reset successfully.', 'pboot'));

                $this->setRedirect(apply_filters('pboot_user_login_resetpass_redirect', add_query_arg(
                    'email', 
                    $type_user->getEmail(), 
                    get_site_url()
                ) . '#open_login'));
            }
            else{
                $this->addErrorMessage($error_message);
            }
        }
        else{
            $hash = Utils_User::addHash($inputs['user_login']);

            $resetpass_url = apply_filters('pboot_user_login_resetpass_url', add_query_arg([
                'email' => $type_user->getEmail(),
                'resetpasshash' => $hash
            ], get_site_url()));
    
            $sent = Utils_Email::sendEmailByAction(
                $type_user->getEmail(),
                'resetpass',
                [
                    '%email%' => $type_user->getEmail(),
                    '%resetpass_url%' => $resetpass_url . '#open_resetpass'
                ]
            );

            $this->setStatus($sent);

            if($sent)
            {
                $this->addSuccessMessage(__('Please, check your email to reset the password.', 'pboot'));
            }
            else{
                $this->addErrorMessage(__('Failed to send password reset email. Please, try again later.', 'pboot'));
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
                '%user_password%' => ($is_by_admin && isset($userdata['user_pass'])) ? $userdata['user_pass'] : __('Contraseña elegida', 'pboot')
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
                $this->addSuccessMessage(__('Verification email sent successfully. Please, check your email box.', 'pboot'));            
            }
            else{
                $this->addErrorMessage(__('Failed to send verification email. Please, try again later.', 'pboot'));
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

    public function checkUserExistsAndVerified($user, $resp)
    {
        if(!is_a($user, '\PBOOT\Type\User'))
        {
            $user = new Type_User($user);
        }

        if(!$user->getId())
        {
            $this->setStatus(false);
            $this->addErrorMessage(__('User not valid.', 'pboot'));
            $this->respond();
        }

        if(Utils_User::emailVerificationEnabled() && !$user->isEmailVerified())
        {
            $this->setStatus(false);
            $this->addErrorMessage(__('Email not verified. <a href="#" class="resend-email-verif" data-user_email="' . $user->getEmail() . '">Resend</a> verification email.', 'pboot'));
            $this->respond();
        }
    }
}