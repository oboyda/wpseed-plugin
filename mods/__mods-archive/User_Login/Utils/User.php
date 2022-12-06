<?php

namespace PBOOT\Mod\User_Login\Utils;

use PBOOT\Utils\Base as Utils_Base;
use PBOOT\Type\User as Type_User;

class User
{
    static function emailVerificationEnabled()
    {
        return apply_filters('pboot_user_login_verif_enabled', false);
    }

    static function getHashes()
    {
        $hashes = get_option('user_hashes');
        return $hashes ? $hashes : [];
    }

    static function addHash($user_login)
    {
        if($user_login)
        {
            $hashes = self::getHashes();

            $hashes[$user_login] = Utils_Base::genHash(20);

            update_option('user_hashes', $hashes);

            return $hashes[$user_login];
        }

        return false;
    }

    static function removeHash($user_login)
    {
        if($user_login)
        {
            $hashes = self::getHashes();

            if(isset($hashes[$user_login]))
            {
                unset($hashes[$user_login]);

                update_option('user_hashes', $hashes);

                return true;
            }
        }

        return false;
    }

    static function validateHash($user_login, $hash, $remove=false)
    {
        if($user_login && $hash)
        {
            $hashes = self::getHashes();

            if(isset($hashes[$user_login]) && $hashes[$user_login] === $hash)
            {
                if($remove)
                {
                    self::removeHash($user_login);
                }

                return true;
            }
        }

        return false;
    }

    static function checkPasswordStrength($password)
    {
        $password_ok = (is_string($password) && strlen($password) >= 5);

        return apply_filters('pboot_user_login_pass_strength', $password_ok, $password);
    }

    static function sendResetPassEmail($user, $hash)
    {
        $type_user = is_a($user, '\PBOOT\Type\User') ? $user : new Type_User($user);

        $user_email = $type_user->getEmail();

        if(empty($user_email))
        {
            return false;
        }

        $resetpass_url = apply_filters('pboot_user_login_resetpass_url', add_query_arg([
            'email' => $user_email,
            'resetpasshash' => $hash
        ], get_site_url()));

        return Utils_Email::sendEmailByAction(
            $user_email,
            'resetpass',
            [
                '%email%' => $user_email,
                '%resetpass_url%' => $resetpass_url . '#open_resetpass'
            ]
        );
    }

    static function sendVerificationEmail($user, $placeholders=[])
    {
        $type_user = is_a($user, '\PBOOT\Type\User') ? $user : new Type_User($user);

        $user_email = $type_user->getEmail();

        if(empty($user_email))
        {
            return false;
        }

        $verif_url = add_query_arg([
            'email' => $user_email,
            'reghash' => self::addHash($user_email)
        ], get_site_url());

        return Utils_Email::sendEmailByAction(
            $user_email,
            'email_verification',
            wp_parse_args($placeholders, [
                '%user_email%' => $user_email,
                '%user_name%' => $type_user->getFullName(),
                '%email_verif_url%' => $verif_url,
                '%user_password%' => __('Selected password', 'pboot')
            ])
        );
    }
}