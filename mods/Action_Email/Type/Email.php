<?php 

namespace PBOOT\Mod\Action_Email\Type;

use PBOOT\Mod\Action_Email\Utils\Email as Utils_Email;

class Email extends \WPSEEDE\Post 
{
    public function __construct($post=null)
    {
        $this->post_type = 'pboot_action_email';

        parent::__construct($post, self::_get_props_config());
    }

    static function _get_props_config()
    {
        return [
            'email_action' => [
                'sys_key' => 'pboot_email_action__action',
                'type' => 'meta'
            ],
            'email_subject' => [
                'sys_key' => 'pboot_email_action__subject',
                'type' => 'meta'
            ],
            'inc_default_header' => [
                'sys_key' => 'pboot_email_action__inc_default_header',
                'type' => 'meta',
                'cast' => 'bool'
            ],
            'inc_default_footer' => [
                'sys_key' => 'pboot_email_action__inc_default_footer',
                'type' => 'meta',
                'cast' => 'bool'
            ]
        ];
    }

    public function getSubject($placeholder_args=[])
    {
        $subject = $this->has_email_subject() ? $this->get_email_subject() : $this->getTitle();
        return $this->replacePlaceholders($subject, $placeholder_args);
    }

    public function getBody($placeholder_args=[])
    {
        return $this->replacePlaceholders($this->getContent(true), $placeholder_args);
    }

    protected function replacePlaceholders($str, $placeholders=[])
    {
        $placeholders = apply_filters('pboot_action_email_placeholders', array_merge($placeholders, Utils_Email::getGlobalPlaceholders()));

        if($str && $placeholders)
        {
            $placeholder_keys = array_keys($placeholders);
            $placeholder_vals = array_values($placeholders);

            $str = str_replace($placeholder_keys, $placeholder_vals, $str);
        }

        return $str;
    }
}