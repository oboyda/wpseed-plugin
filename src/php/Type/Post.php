<?php 

namespace PBOOT\Type;

class Post extends \WPSEED\Post
{
    public function __construct($post=null)
    {
        parent::__construct($post, self::_get_props_config());
    }

    static function _get_props_config()
    {
        return array_merge(parent::_get_props_config(), [
            
        ]);
    }
}
