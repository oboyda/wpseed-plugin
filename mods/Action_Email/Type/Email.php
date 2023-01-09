<?php 

namespace PBOOT\Mod\Action_Email\Type;

use PBOOT\Type\Post;
use PBOOT\Mod\Action_Email\Utils\Email as Utils_Email;

class Email extends Post
{
    public function __construct($post=0)
    {
        $this->post_type = 'action_email';

        parent::__construct($post);
    }

    public function getAction()
    {
        return $this->getId() ? get_post_meta($this->getId(), '_email_action', true) : false;
    }

    public function getSubject($placeholder_args=[])
    {
        return $this->replacePlaceholders($this->getTitle(), $placeholder_args);
    }

    public function getBody($placeholder_args=[])
    {
        return $this->replacePlaceholders($this->getContent(true), $placeholder_args);
    }

    public function hasDefaultHeader()
    {
        return $this->getId() ? (bool)get_post_meta($this->getId(), '_inc_default_header', true) : false;
    }

    public function hasDefaultFooter()
    {
        return $this->getId() ? (bool)get_post_meta($this->getId(), '_inc_default_footer', true) : false;
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