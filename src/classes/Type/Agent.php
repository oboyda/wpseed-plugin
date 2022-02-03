<?php 

namespace HSP\Type;

use WPSEED\User;

class Agent extends User
{
    public function __construct($user=null)
    {
        parent::__construct($user, []);
    }

    public function get_profile_image_id()
    {
        return (int)$this->get_meta('user_profile_image', true);
    }

    public function get_profile_image_src($size='full', $default_gravatar=false)
    {
        $image_id = $this->get_profile_image_id();
        $image_src = $image_id ? wp_get_attachment_image_src($image_id, $size) : [];
        return isset($image_src[0]) ? $image_src[0] : ($default_gravatar ? get_avatar_url($this->get_id()) : '');
    }

    public function get_profile_image_html($size='full')
    {
        $image_id = $this->get_profile_image_id();
        $image_html = $image_id ? wp_get_attachment_image($image_id, $size) : '';
        return $image_html ? $image_html : ($default_gravatar ? get_avatar($this->get_id()) : '');
    }

    public function get_phone($for_href=false)
    {
        $phone = $this->get_meta('contact_phone');
        if($for_href && $phone)
        {
            $phone = str_replace([' ', '-'], '', $phone);
        }
        return $phone;
    }

    public function get_email()
    {
        return $this->get_data('user_email');
    }

    public function get_first_name()
    {
        return $this->get_meta('first_name', true, '');
    }

    public function get_last_name()
    {
        return $this->get_meta('last_name', true, '');
    }

    public function get_full_name()
    {
        $first_name = $this->get_first_name();
        $last_name = $this->get_last_name();

        return trim($first_name . ' ' . $last_name);
    }

}