<?php

namespace PBOOT\Utils;

class Base
{
    static function getOption($name, $default=null)
    {
        return pboot_get_option($name, $default);
    }

    /* ------------------------------ */

    static function getLanguages()
    {
        $langs = [];
        $langs_options = function_exists('pll_the_languages') ? pll_the_languages(['echo' => false, 'raw' => true]) : [];

        if($langs_options)
        {
            foreach($langs_options as $_lang)
            {
                $lang['code'] = isset($_lang['slug']) ? $_lang['slug'] : 'en';
                $lang['locale'] = isset($_lang['locale']) ? $_lang['locale'] : $lang['code'];
                $lang['name'] = isset($_lang['name']) ? $_lang['name'] : '';
                $lang['url'] = isset($_lang['url']) ? $_lang['url'] : '';
                $lang['current'] = isset($_lang['current_lang']) ? (bool)$_lang['current_lang'] : false;

                $langs[$lang['code']] = $lang;
            }
        }

        return $langs;
    }

    static function getLanguageParam($lang_code, $param)
    {
        $languages = self::getLanguages();
        return (isset($languages[$lang_code]) && isset($languages[$lang_code][$param])) ? $languages[$lang_code][$param] : false;
    }

    static function getCurrentLanguage($as_code=true)
    {
        // Customizer fix
        if(!isset($_REQUEST['lang']) && is_admin() && isset($_GET['customize_changeset_uuid']) && Session::getCookie('lang'))
        {
            return $as_code ? Session::getCookie('lang') : self::getLanguageParam(Session::getCookie('lang'), 'locale');
        }

        $locale = function_exists('pll_current_language') ? pll_current_language('locale') : get_locale();
        $locale = str_replace('_', '-', $locale);

        return $as_code ? substr($locale, 0, 2) : $locale;
    }

    static function getDefaultLanguage($as_code=true)
    {
        $locale = function_exists('pll_default_language') ? pll_default_language('locale') : get_locale();
        $locale = str_replace('_', '-', $locale);

        return $as_code ? substr($locale, 0, 2) : $locale;
    }

    /* ------------------------------ */

    static function parseArrInts($arr)
    {
        $_arr = [];
        if(!empty($arr))
        {
            foreach($arr as $arr_item)
            {
                $_arr[] = (int)$arr_item;
            }
        }
        return $_arr;
    }

    static function checkArrayEmptyVals($arr, $include=[], $empty_compare=[])
    {
        $empty_keys = [];

        foreach((array)$arr as $k => $a)
        {
            if($include && !in_array($k, $include))
            {
                continue;
            }

            if($empty_compare)
            {
                if(in_array($a, $empty_compare, true))
                {
                    $empty_keys[] = $k;
                }
            }
            elseif(empty($a))
            {
                $empty_keys[] = $k;
            }
        }

        return $empty_keys;
    }

    static function filterArrayEmptyVals($arr, $include=[], $empty_compare=[])
    {
        $empty_keys = self::checkArrayEmptyVals($arr, $include=[], $empty_compare=[]);

        if(!$empty_keys)
        {
            return $arr;
        }

        $_arr = [];

        foreach($arr as $k => $a)
        {
            if(!in_array($k, $empty_keys))
            {
                $_arr[$k] = $a;
            }
        }

        return $_arr;
    }

    /* ------------------------------ */
    
    static function getTermData($field, $term, $taxonomy)
    {
        $wp_term = is_int($term) ? get_term($term, $taxonomy) : get_term_by('slug', $term, $taxonomy);

        if(is_a($wp_term, 'WP_Term') && isset($wp_term->$field))
        {
            return $wp_term->$field;
        }

        return null;
    }

    static function makeTermsHierarchy($term_ids, $taxonomy, $implode_conf=[])
    {
        $terms_h = [];

        if($term_ids)
        {
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
                'include' => $term_ids
            ]);

            if(!is_wp_error($terms) && $terms)
            {
                $c = 0;
                $terms_i = [];
                while((count($terms_i) <= count($terms)) && $c < 100)
                {
                    foreach($terms as $i => $term)
                    {
                        if(!in_array($term->term_id, $terms_i))
                        {
                            self::makeTermsHierarchyFindParent($terms_h, $terms_i, $term);
                        }
                    }
                    $c++;
                }
            }
        }

        if(!empty($implode_conf))
        {
            $walk_args = [
                'conf' => wp_parse_args($implode_conf, [
                    'implode' => true,
                    'term_key' => 'name',
                    'skip_top' => false,
                    'sep' => ', ',
                    'reverse' => false
                ]), 
                'implode_parts' => []
            ];

            array_walk_recursive($terms_h, function($item, $key) use (&$walk_args){

                if(is_a($item, 'WP_Term'))
                {
                    if($walk_args['conf']['skip_top'] && !$item->parent)
                    {
                        return;
                    }

                    $term_key = $walk_args['conf']['term_key'];

                    if(isset($item->$term_key))
                    {
                        $walk_args['implode_parts'][] = $item->$term_key;
                    }
                }

            }, $walk_args);

            if($walk_args['implode_parts'] && $walk_args['conf']['reverse'])
            {
                $walk_args['implode_parts'] = array_reverse($walk_args['implode_parts']);
            }

            if($walk_args['conf']['implode'])
            {
                return implode($walk_args['conf']['sep'], $walk_args['implode_parts']);
            }

            return $walk_args['implode_parts'];
        }

        return $terms_h;
    }

    static function makeTermsHierarchyFindParent(&$terms_h, &$terms_i, $term)
    {
        $p_key = 'term_' . $term->parent;
        $c_key = 'term_' . $term->term_id;

        if(!$term->parent)
        {
            //Top level, no parent
            $terms_h[$c_key] = [
                'term' => $term,
                'children' => []
            ];

            $terms_i[] = $term->term_id;
        }
        elseif($terms_h)
        {
            foreach($terms_h as $key => &$term_h)
            {
                if($p_key === $key)
                {
                    //Parent found
                    $term_h['children'][$c_key] = [
                        'term' => $term,
                        'children' => []
                    ];

                    $terms_i[] = $term->term_id;
                }
                else
                {
                    self::makeTermsHierarchyFindParent($term_h['children'], $terms_i, $term);
                }
            }
        }
    }

    /* ------------------------------ */
    
    /*
    @param string $cast integer|float
    */
    static function getMetaValsRange($meta_key, $as_string=false, $cast='integer')
    {
        global $wpdb;

        $range = [
            'min' => $wpdb->get_var($wpdb->prepare("SELECT MIN(CAST(meta_value AS DECIMAL)) FROM $wpdb->postmeta WHERE meta_key=%s", $meta_key)),
            'max' => $wpdb->get_var($wpdb->prepare("SELECT MAX(CAST(meta_value AS DECIMAL)) FROM $wpdb->postmeta WHERE meta_key=%s", $meta_key))
        ];

        switch($cast)
        {
            case 'integer':
                $range['min'] = intval($range['min']);
                $range['max'] = intval($range['max']);
                break;
            case 'float':
                $range['min'] = floatval($range['min']);
                $range['max'] = floatval($range['max']);
                break;
        }

        return $as_string ? $range['min'] . '-' . $range['max'] : $range;
    }

    /*
    @param string $cast integer|float
    */
    static function getMetaValsUnique($meta_key, $cast='integer', $as_options=false)
    {
        global $wpdb;

        $vals = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key=%s", $meta_key));

        if($vals)
        {
            foreach($vals as &$val)
            {
                switch($cast)
                {
                    case 'integer':
                        $val = intval($val);
                        break;
                    case 'float':
                        $val = floatval($val);
                        break;
                }
            }

            if(in_array($cast, ['integer', 'float']))
            {
                sort($vals, SORT_NUMERIC);
            }
            else{
                sort($vals, SORT_STRING);
            }

            if($as_options)
            {
                $options = [];
                foreach($vals as $val)
                {
                    $options[] = [
                        'value' => $val,
                        'name' => $val
                    ];
                }
                $vals = $options;
            }
        }

        return $vals;
    }

    /* ------------------------------ */

    static function genId($pref='', $sfx='')
    {
        $chars = str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890');
        return $pref . substr(str_shuffle($chars), 0, 10) . $sfx;
    }

    static function genHash($type='default')
    {
        $hash = '';
        $nums = '0123456789';
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if($type == 'default')
        {
            $hash = $nums . $chars;
            $hash = str_shuffle($hash);
            $hash = substr($hash, 0, 20);
        }
        elseif($type == 'vcode'){

            $hash = $nums;
            $hash = str_shuffle($hash);
            $hash = substr($hash, 0, 6);
        }

        return $hash;
    }
    
    static function isAdmin()
    {
        return (is_admin() && (!wp_doing_ajax() || isset($_POST['block'])));
    }

    /*
    * Select options
    * -------------------------
    */

    static function getPostSelectOptions($post_type='page', $args=[])
    {
        $options = [];

        $args = wp_parse_args($args, [
            'post_type' => $post_type,
            'posts_per_page' => 100,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        $posts_q = new \WP_Query($args);

        if($posts_q->posts)
        {
            foreach($posts_q->posts as $post)
            {
                $options[$post->ID] = $post->post_title;
            }
        }

        return $options;
    }

    static function getTermSelectOptions($taxonomy, $field='term_id', $args=[])
    {
        $options = [];

        $args = wp_parse_args($args, [
            'meta_key' => '',
            'meta_value' => '',
            'meta_parent_term_id' => 0,
            'orderby' => 'name',
            'order' => 'ASC'
        ]);
        if($_args['meta_parent_term_id'])
        {
            $_args['meta_key'] = 'parent_term_id';
            $_args['meta_value'] = $_args['meta_parent_term_id'];
        }
        $q_args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'meta_key' => $args['meta_key'],
            'meta_value' => $args['meta_value']
        ];

        $terms = get_terms($q_args);

        if(!is_wp_error($terms))
        {
            foreach($terms as $term)
            {
                $options[$term->$field] = $term->name;
            }
        }
        
        return $options;
    }
}