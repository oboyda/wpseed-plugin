<?php 

namespace PBOOT\Type;

use PBOOT\Utils\Base as Utils_Base;

class Post extends \WPSEED\Post
{
    public function __construct($post=null, $props_config=[])
    {
        parent::__construct($post, $props_config);
    }

    static function getPropConfigData($key, $data_key=null, $default=null)
    {
        $props_config = static::_get_props_config();

        $prop_config = isset($props_config[$key]) ? $props_config[$key] : null;

        if(isset($data_key))
        {
            return isset($prop_config[$data_key]) ? $prop_config[$data_key] : $default;
        }

        return isset($prop_config) ? $prop_config : $default;
    }

    static function getPropOptionLabel($key, $option_value)
    {
        $options = self::getPropConfigData($key, 'options', []);

        return isset($options[$option_value]) ? $options[$option_value] : false;
    }

    public function getId()
    {
        return $this->get_id();
    }

    public function getTitle()
    {
        return $this->get_data('post_title', '');
    }

    public function getExcerpt($autop=false)
    {
        $data = $this->get_data('post_excerpt', '');

        if($data)
        {
            if($autop)
            {
                $data = wpautop($data);
            }
        }

        return $data;
    }

    public function getContent($autop=false, $words_num=null)
    {
        $data = $this->get_data('post_content', '');

        if($data)
        {
            if(isset($words_num))
            {
                $data = wp_trim_words($data, $words_num);
            }
            if($autop)
            {
                $data = wpautop($data);
            }
        }

        return $data;
    }

    public function getLink()
    {
        return $this->get_permalink();
    }

    public function getAuthor()
    {
        return $this->get_data('post_author');
    }

    /*
    Images
    -------------------------
    */

    public function getFeaturedImageId()
    {
        return get_post_thumbnail_id($this->get_id());
    }
    public function getFeaturedImageSrc($size='thumbnail', $placeholder=false)
    {
        $image_id = $this->getFeaturedImageId();
        $att_image_src = $image_id ? wp_get_attachment_image_src($image_id, $size) : [];
        $image_src = ($att_image_src && isset($att_image_src[0])) ? $att_image_src[0] : '';

        return (empty($image_src) && $placeholder) ? (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src($size) : $image_src) : $image_src;
    }
    public function hasFeaturedImage()
    {
        $image_id = $this->getFeaturedImageId();
        return !empty($image_id);
    }

    /*
    Helpers
    -------------------------
    */

    public function hasProp($key)
    {
        $prop = $this->getProp($key);
        return !empty($prop);
    }

    public function getProp($key, $default=null)
    {
        $sys_key = $this->getPropConfigData($key, 'sys_key', $key);
        $type = $this->getPropConfigData($key, 'type', 'meta');
        $cast = $this->getPropConfigData($key, 'cast', false);
        $term_single = $this->getPropConfigData($key, 'term_single', false);

        $prop = null;

        switch($type)
        {
            case 'meta':
                $prop = $this->get_meta($sys_key, true);
                break;
            case 'data':
                $prop = $this->get_data($sys_key);
                break;
            case 'attachment':
                $prop = $this->get_meta($sys_key, true);
                $cast = 'integer';
                break;
            case 'attachment_list':
                $prop = $this->get_meta($sys_key, true);
                $cast = 'integer';
                break;
            case 'taxonomy':
                $prop = $this->getTerms($sys_key, 'ids', $term_single);
                break;
            }

        if($cast)
        {
            if(is_array($prop))
            {
                array_walk($prop, [$this, 'castPropVal'], $cast);
            }
            else
            {
                $this->castPropVal($prop, null, $cast);
            }
        }

        return (empty($prop) && isset($default)) ? $default : $prop;
    }

    protected function castPropVal(&$prop, $key, $cast)
    {
        $prop = Utils_Base::castVal($prop, $cast);
    }

    public function getTerms($taxonomy, $fields='ids', $single=true)
    {
        $term_ids = $this->get_terms($taxonomy);

        if($fields === 'ids')
        {
            return $single ? (isset($term_ids[0]) ? $term_ids[0] : false) : $term_ids;
        }

        $args = [
            'taxonomy' => $taxonomy,
            'include' => $term_ids,
            'fields' => $fields
        ];

        $terms = get_terms($args);

        if(is_wp_error($terms))
        {
            return $single ? false : [];
        }

        if($single)
        {
            return isset($terms[0]) ? $terms[0] : false;
        }

        return $terms;
    }
}
