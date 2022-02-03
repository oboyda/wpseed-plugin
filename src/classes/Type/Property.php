<?php 

namespace HSP\Type;

use WPSEED\Post;
use HSP\Utils_Property;

class Property extends Post
{
    public function __construct($post=null)
    {
        $this->post_type = 'property';

        if(is_string($post))
        {
            $post = $this->getPropertyIdByReference($post);
        }

        parent::__construct($post, self::_get_props_config());
    }

    static function _get_props_config()
    {
        return [

            'post_title' => [
                'type' => 'data'
            ],
            'post_content' => [
                'type' => 'data',
                'import_key' => 'Description'
            ],

            'ref' => [
                'type' => 'meta',
                'import_key' => 'Reference'
            ],
            'import_id' => [
                'type' => 'meta',
                'import_key' => 'ID'
            ],

            'country' => [
                'type' => 'taxonomy',
                'import_key' => 'Country'
            ],
            'state' => [
                'type' => 'taxonomy',
                'import_key' => 'District'
            ],
            'city' => [
                'type' => 'taxonomy',
                'import_key' => 'Municipality'
            ],
            'parish' => [
                'type' => 'taxonomy',
                'import_key' => 'Parish'
            ],
            'zone' => [
                'type' => 'taxonomy',
                'import_key' => 'Zone'
            ],
            'property_type' => [
                'type' => 'taxonomy',
                'import_key' => 'Type'
            ],
            'property_feature' => [
                'type' => 'taxonomy',
                'import_key' => 'Features'
            ],
            'property_condition' => [
                'type' => 'taxonomy',
                'import_key' => 'Condition'
            ],

            // 'sale_price' => [
            //     'type' => 'meta',
            //     'import_key' => 'Price',
            //     'cast' => 'integer'
            // ],
            'bedrooms' => [
                'type' => 'meta',
                'import_key' => 'Rooms',
                'cast' => 'integer'
            ],
            'bathrooms' => [
                'type' => 'meta',
                'import_key' => 'Bathrooms',
                'cast' => 'integer'
            ],
            'floor' => [
                'type' => 'meta',
                'import_key' => 'Floor',
                'cast' => 'integer'
            ],
            'gross_area' => [
                'type' => 'meta',
                'import_key' => 'GrossArea',
                'cast' => 'integer'
            ],
            'net_area' => [
                'type' => 'meta',
                'import_key' => 'NetArea',
                'cast' => 'integer'
            ],
            'land_area' => [
                'type' => 'meta',
                'import_key' => 'LandArea',
                'cast' => 'integer'
            ],

            'thumbnail_url' => [
                'type' => 'meta',
                'import_key' => 'Thumbnail'
            ],
            'gallery_urls' => [
                'type' => 'meta',
                'import_key' => 'Images'
            ],

            'year' => [
                'type' => 'meta',
                'import_key' => 'Year'
            ],
            'zip_code' => [
                'type' => 'meta',
                'import_key' => 'ZipCode'
            ],

            'energy_cert' => [
                'type' => 'meta',
                'import_key' => 'EnergyCertification'
            ],
            'energy_cert_validity' => [
                'type' => 'meta',
                'import_key' => 'EnergyCertificationValidity'
            ],
            'energy_cert_number' => [
                'type' => 'meta',
                'import_key' => 'EnergyCertificationNumber'
            ],

            'gsp_lat' => [
                'type' => 'meta',
                'import_key' => 'GSPLat'
            ],
            'gsp_lon' => [
                'type' => 'meta',
                'import_key' => 'GSPLon'
            ]
        ];
    }

    protected function getPropertyIdByReference($ref)
    {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key=%s AND meta_value=%s", 'ref', $ref));
    }

    public function getFeaturedImageId()
    {
        return get_post_thumbnail_id($this->get_id());
    }

    public function getFeaturedImageSrc()
    {
        return $this->get_meta('thumbnail_url');
    }

    /*
    Property general info
    -------------------------
    */

    public function getAddressFormatted()
    {
        return 'Property address';
    }

    public function getSalePrice($format=false)
    {
        $price = (int)$this->get_meta('sale_price');

        return $format ? Utils_Property::formatPrice($price) : $price;
    }

    public function getReference()
    {
        return $this->get_meta('ref');
    }

    public function getNetArea($formatted=false)
    {
        $area = (int)$this->get_meta('net_area');

        return $formatted ? Utils_Property::formatArea($area) : $area;
    }

    public function getGrossArea($formatted=false)
    {
        $area = (int)$this->get_meta('gross_area');
        
        return $formatted ? Utils_Property::formatArea($area) : $area;
    }

    public function getLandArea($formatted=false)
    {
        $area = (int)$this->get_meta('land_area');
        
        return $formatted ? Utils_Property::formatArea($area) : $area;
    }

    public function getBedrooms()
    {
        return (int)$this->get_meta('bedrooms');
    }

    public function getBathrooms()
    {
        return (int)$this->get_meta('bathrooms');
    }

    /*
    Property specifications
    -------------------------
    */

    public function getDescription($autop=false)
    {
        $desc = $this->get_data('post_content');

        return ($autop && $desc) ? wpautop($desc) : $desc;
    }

    /*
    Property amenities
    -------------------------
    */


}
