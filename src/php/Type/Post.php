<?php 

namespace PBOOT\Type;

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
            return isset($prop_config[$data_key]) ? $prop_config[$data_key] : (isset($default) ? $default : null);
        }

        return isset($prop_config) ? $prop_config : (isset($default) ? $default : $prop_config);
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

    /*
    Images
    -------------------------
    */

    public function getFeaturedImageId()
    {
        return get_post_thumbnail_id($this->get_id());
    }

    public function getFeaturedImageSrc($size='thumbnail')
    {
        $image_id = $this->getFeaturedImageId();
        $image_src = $image_id ? wp_get_attachment_image_src($image_id, $size) : [];
        return ($image_src && isset($image_src[0])) ? $image_src[0] : '';
    }

    public function getFeaturedImage($size='thumbnail', $rel_class='rect-150-100')
    {
        $image_id = $this->getFeaturedImageId();
        return $image_id ? $this->getAttachmentImageHtml($image_id, $size, $rel_class) : '';
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
        $conf = isset($this->props_config[$key]) ? $this->props_config[$key] : [];

        $sys_key = isset($conf['sys_key']) ? $conf['sys_key'] : $key;
        $type = isset($conf['type']) ? $conf['type'] : 'meta';
        $cast = isset($conf['cast']) ? $conf['cast'] : false;

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
        switch($cast)
        {
            case 'integer':
                $prop = intval($prop);
                break;
            case 'floatval':
                $prop = floatval($prop);
                break;
            case 'boolean':
                $prop = boolval($prop);
                break;
        }
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
