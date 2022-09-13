<?php 

namespace PBOOT\Mod\Type;

// use PBOOT\Mod\Business_Register\Utils\Business as Utils_Business;

class Business extends \WPSEED\Post
{
    public function __construct($post=null)
    {
        $this->post_type = 'business';

        parent::__construct($post, self::_get_props_config());
    }

    static function _get_props_config()
    {
        return [

            'post_title' => [
                'type' => 'data'
            ],
            'post_content' => [
                'type' => 'data'
            ],

            'country' => [
                'type' => 'meta'
            ],
            'state' => [
                'type' => 'meta'
            ],
            'city' => [
                'type' => 'meta'
            ],
            'zip_code' => [
                'type' => 'meta'
            ],
            'address' => [
                'type' => 'meta'
            ],
            'gps_lat' => [
                'type' => 'meta'
            ],
            'gps_lon' => [
                'type' => 'meta'
            ],

            'vat_id' => [
                'type' => 'meta'
            ],

            'logo_image' => [
                'type' => 'attachment'
            ],
            'featured_image' => [
                'sys_key' => '_thumbnail_id',
                'type' => 'attachment'
            ],
            'gallery_images' => [
                'type' => 'attachment_list'
            ]
        ];
    }
}
