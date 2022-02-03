<?php

namespace HSP;

use HSP\Type\Property;

class Api_Import
{
    var $branch;
    var $lang;

    var $page;
    var $per_page;
    var $page_max;

    var $imported_refs;

    var $time;

    var $session_id;
    // var $session_file;
    // var $session;
    var $log_file;
    var $log;

    const IMPORT_DIR_NAME = 'hs-import';

    public function __construct($branch_id, $args=[])
    {
        $args = wp_parse_args($args, [
            'page' => 1,
            'per_page' => 50,
            'session_id' => ''
        ]);

        $this->branch = $branch_id;

        $this->page = $args['page'];
        $this->per_page = $args['per_page'];
        $this->page_max = 1;

        $this->imported_refs = [];

        $this->time = gmdate('Y-m-d--H-i-s');

        $this->setLang();
        $this->setSession($args['session_id']);
    }

    public function setPage($page=1)
    {
        $this->page = $page;
    }

    public function setPerPage($per_page=1)
    {
        $this->per_page = $per_page;
    }

    public function getPageMax()
    {
        return $this->page_max;
    }

    public function getImportedRefs()
    {
        return $this->imported_refs;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    protected function setLang()
    {
        $this->lang = strtoupper(str_replace('_', '-', get_locale()));
    }

    protected function setSession($session_id='')
    {

        $this->session_id = $session_id ? $session_id : time();

        $uploads_dir = wp_get_upload_dir();
        $basedir = isset($uploads_dir['basedir']) ? $uploads_dir['basedir'] : null;

        if(!file_exists($basedir))
        {
            mkdir($basedir, 0755);
        }

        $import_dir = isset($basedir) ? $basedir . '/' . self::IMPORT_DIR_NAME : null;

        if(!file_exists($import_dir))
        {
            mkdir($import_dir, 0755);
        }

        // $this->session_file = isset($import_dir) ? $import_dir . '/session' : null;
        // $this->session = [
        //     'page' => 1,
        //     'imported_refs' => []
        // ];
        // if(isset($this->session_file) && file_exists($this->session_file))
        // {
        //     $this->session = json_decode(file_get_contents($this->session_file), true);
        // }
        
        $log_dir = isset($import_dir) ? $import_dir . '/log' : null;

        if(!file_exists($log_dir))
        {
            mkdir($log_dir, 0755);
        }
        $this->log_file = isset($log_dir) ? $log_dir . '/log-' . $this->session_id : null;
        // $this->log = file_exists($this->log_file) ? file_get_contents($this->log_file) : '';
    }

    protected function logImport()
    {
        $n = "\n\r";
        $log_info = '';

        if($this->imported_refs)
        {
            $log_info .= sprintf(__('Time: %s', 'hsp'), $this->time) . $n;
            $log_info .= sprintf(__('Page: %d', 'hsp'), $this->page) . $n;
            $log_info .= sprintf(__('Imported refs: %s', 'hsp'), implode(', ', $this->imported_refs)) . $n;
            $log_info .= $n;
            $log_info .= str_repeat('-', 50) . $n;
            $log_info .= $n;
        }

        if($log_info)
        {
            file_put_contents($this->log_file, $log_info, FILE_APPEND);
        }
    }

    public function importProperties()
    {
        // if($this->page > $this->page_max)
        // {
        //     return $this->imported_refs;
        // }

        $api_resp = Api_Req::post($this->branch, '/Properties', [
            'PAG' => $this->page,
            'NRE' => $this->per_page
        ], [
            'Language' => $this->lang
        ]);

        $total = isset($api_resp['data']['TotalRecords']) ? (int)$api_resp['data']['TotalRecords'] : 0;

        if($total && $this->per_page < $total)
        {
            $this->page_max = ceil($total / $this->per_page);
        }

        $properties_data = isset($api_resp['data']['Properties']) ? $api_resp['data']['Properties'] : [];

        $inserted_refs = $this->insertProperties($properties_data);

        if($inserted_refs)
        {
            $this->imported_refs = array_merge($this->imported_refs, $inserted_refs);
        }

        $this->logImport();

        return $this->imported_refs;
    }

    protected function insertProperties($properties_data)
    {
        $inserted = [];

        foreach($properties_data as $property_data)
        {
            if(!empty($property_data['Reference']))
            {
                $property = new Property($property_data['Reference']);
                $props_config = $property->get_props_config();

                foreach($props_config as $key => $prop_config)
                {
                    if(isset($prop_config['import_key']))
                    {
                        $i_key = $prop_config['import_key'];

                        $prop_val = isset($property_data[$i_key]) ? $property_data[$i_key] : null;
                        if(isset($prop_config['default']) && empty($prop_val))
                        {
                            $prop_val = $prop_config['default'];
                        }
                        if(!isset($prop_val))
                        {
                            continue;
                        }

                        if(isset($prop_config['cast']) && isset($prop_val))
                        {
                            $prop_val = self::castValue($prop_val, $prop_config['cast']);
                        }

                        // if($key == 'gallery_urls')
                        // {
                        //     $gallery_urls = [];
                        //     foreach($prop_val as $image)
                        //     {
                        //         $gallery_url = [];
                        //         if(isset($image['Thumbnail']))
                        //         {
                        //             $gallery_url['thumbnail'] = $image['Thumbnail'];
                        //         }
                        //         if(isset($image['Original']))
                        //         {
                        //             $gallery_url['original'] = $image['Original'];
                        //         }
                        //         if(isset($image['Thumbnail_1280x960']))
                        //         {
                        //             $gallery_url['thumbnail_1280x960'] = $image['Thumbnail_1280x960'];
                        //         }
                        //     }
                        // }

                        switch($prop_config['type'])
                        {
                            case 'data':

                                $property->set_data($key, $prop_val);
                                break;

                            case 'meta':

                                $property->set_meta($key, $prop_val);
                                break;

                            case 'taxonomy':

                                if(is_string($prop_val))
                                {
                                    $term_id = 0;

                                    $term_e = get_term_by('name', $prop_val, $key);
                                    if(is_a($term_e, 'WP_Term'))
                                    {
                                        $term_id = $term_e->term_id;
                                    }
                                    else{
                                        $term_c = wp_insert_term($prop_val, $key);
                                        if(!is_wp_error($term_c) && isset($term_c['term_id']))
                                        {
                                            $term_id = $term_c['term_id'];
                                        }
                                    }

                                    if($term_id)
                                    {
                                        $property->set_terms($key, [$term_id]);
                                    }
                                }
                                break;
                        }
                    }
                }

                //Set property title
                $property->set_data('post_title', sprintf(__('Property %s', 'hsp'), $property_data['Reference']));

                //Set property branch
                if($this->branch)
                {
                    $property->set_terms('branch', [$this->branch]);
                }

                //Create/save property
                $property->persist();

                if($property->get_id())
                {
                    $inserted[] = $property_data['Reference'];
                }
            }
        }

        return $inserted;
    }

    static function castValue($val, $type)
    {
        switch($type)
        {
            case 'integer':
                $val = intval($val);
                break;
            case 'float':
                $val = floatval($val);
                break;
        }
        return $val;
    }
}
