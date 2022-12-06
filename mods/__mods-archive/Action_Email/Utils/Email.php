<?php 

namespace PBOOT\Mod\Action_Email\Utils;

use PBOOT\Mod\Action_Email\Type\Email as Type_Email;

class Email 
{
    static function getEmailActions()
    {
        return apply_filters('pboot_action_email_actions', [
            'resetpass' => __('Reset password', 'pboot'),
            'email_verification' => __('Verification emil', 'pboot'),
        ]);
    }

    static function getGlobalPlaceholders()
    {
        return [
            '%sitename%' => get_bloginfo('name'),
            '%siteurl%' => get_site_url()
        ];
    }

    static function getFromName()
    {
        return apply_filters('pboot_action_email_from_name', get_option('blogname'));
    }

    static function getFromEmail()
    {
        return apply_filters('pboot_action_email_from_email', get_option('admin_email'));
    }

    static function getEmailByAction($action)
    {
        $q_args = [
            'post_type' => 'action_email',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => '_email_action',
                    'value' => $action,
                    'type' => 'CHAR',
                    'compare' => '='
                ]
            ],
        ];

        $q = new \WP_Query($q_args);

        return isset($q->posts[0]) ? new Type_Email($q->posts[0]) : false;
    }

    static function sendEmailByAction($to_email, $action, $placeholder_args=[])
    {
        $email_post = self::getEmailByAction($action);

        if(!is_a($email_post, '\PBOOT\Type\Email'))
        {
            return false;
        }

        $subject = $email_post->getSubject($placeholder_args);
        $body = $email_post->getBody($placeholder_args);
        $headers = [
            'Content-Type: text/html; charset=UTF-8'
            // 'From: ' . self::getFromName() . ' <' . self::getFromEmail() . '>'
        ];

        $sent = wp_mail($to_email, $subject, $body, $headers);

        // file_put_contents(ABSPATH . '/__debug.txt', print_r([
        //     time(),
        //     (int)$sent,
        //     $to_email,
        //     $headers,
        //     $subject,
        //     $body
        // ], true));

        return $sent;
    }
}