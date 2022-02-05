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
            'property_condition' => [
                'type' => 'taxonomy',
                'import_key' => 'Condition'
            ],
            'property_feature' => [
                'type' => 'taxonomy',
                'import_key' => 'Features'
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

    /*
    Images
    -------------------------
    */

    public function getFeaturedImageId()
    {
        return get_post_thumbnail_id($this->get_id());
    }

    public function getGalleryImages()
    {
        return $this->get_meta('gallery_urls', true, []);
    }

    public function getFeaturedImageSrc($size='Original')
    {
        $meta = $this->get_meta('thumbnail_url', true);

        if($size !== 'Original' && $meta)
        {
            $gallery_meta = $this->getGalleryImages();
            foreach($gallery_meta as $g_meta)
            {
                if(isset($g_meta['Original']) && $meta === $g_meta['Original'] && isset($g_meta[$size]))
                {
                    $meta = $g_meta[$size];
                }
            }
        }

        return $meta;
    }

    public function getGalleryImageSrcs($size='Original')
    {
        $images_meta = $this->getGalleryImages();
        $images = [];

        foreach($images_meta as $image)
        {
            if(isset($image[$size]))
            {
                $images[] = $image[$size];
            }
        }
        return $images;
    }

    /*
    Property details
    -------------------------
    */

    public function getTitle()
    {
        return $this->get_data('post_title', '');
    }

    public function getDescription($autop=false)
    {
        $data = $this->get_data('post_content', '');

        return ($autop && $data) ? wpautop($data) : $data;
    }

    public function getAddressFormatted()
    {
        return 'Property address';
    }

    public function getSalePrice($format=false)
    {
        $meta = (int)$this->get_meta('sale_price', true);

        return $format ? Utils_Property::formatPrice($meta) : $meta;
    }

    public function getReference()
    {
        return $this->get_meta('ref', true);
    }

    public function getNetArea($formatted=false)
    {
        $meta = (int)$this->get_meta('net_area', true);

        return $formatted ? Utils_Property::formatArea($meta) : $meta;
    }

    public function getGrossArea($formatted=false)
    {
        $meta = (int)$this->get_meta('gross_area', true);
        
        return $formatted ? Utils_Property::formatArea($meta) : $meta;
    }

    public function getLandArea($formatted=false)
    {
        $meta = (int)$this->get_meta('land_area', true);
        
        return $formatted ? Utils_Property::formatArea($meta) : $meta;
    }

    public function getBedrooms()
    {
        return (int)$this->get_meta('bedrooms', true);
    }

    public function getBathrooms()
    {
        return (int)$this->get_meta('bathrooms', true);
    }

    public function getFloor()
    {
        return (int)$this->get_meta('floor', true);
    }

    /*
    Property terms
    -------------------------
    */

    public function getCountry($names=false)
    {
        return $this->getTerms('country', $names, true);
    }

    public function getState($names=false)
    {
        return $this->getTerms('state', $names, true);
    }

    public function getCity($names=false)
    {
        return $this->getTerms('city', $names, true);
    }

    public function getPerish($names=false)
    {
        return $this->getTerms('perish', $names, true);
    }

    public function getZone($names=false)
    {
        return $this->getTerms('zone', $names, true);
    }

    public function getType($names=false)
    {
        return $this->getTerms('property_type', $names, true);
    }

    public function getCondition($names=false)
    {
        return $this->getTerms('property_condition', $names, true);
    }

    public function getFeatures($names=false, $as_array=false)
    {
        return $this->getTerms('property_feature', $names, false, $as_array);
    }

    /*
    Property amenities
    -------------------------
    */

    /*
    Helpers
    -------------------------
    */

    // protected function getTermsObjects($taxonomy)
    // {
    //     $terms = get_terms([
    //         'taxonomy' => $taxonomy,
    //         'hide_empty' => false,
    //         'include' => $this->get_terms($taxonomy, [])
    //     ]);
    //     $_terms = is_wp_error($terms) ? [] : $terms;
    // }

    protected function getTerms($taxonomy, $names=false, $single=true, $as_array=false)
    {
        if($names)
        {
            return $as_array ? $this->getTermsNames($taxonomy) : $this->getTermsNames($taxonomy, ', ');
        }

        $term_ids = $this->get_terms($taxonomy, []);

        if($single)
        {
            return isset($term_ids[0]) ? $term_ids[0] : false;
        }
        
        return $term_ids;
    }

    protected function getTermsNames($taxonomy, $concat=false)
    {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'include' => $this->get_terms($taxonomy, []),
            'fields' => 'names'
        ]);
        $_terms = is_wp_error($terms) ? [] : $terms;

        return $concat ? implode($concat, $_terms) : $_terms;
    }
}
