<?php 

namespace PBOOT\Type;

class User extends \WPSEEDE\User 
{
    public function __construct($user=null)
    {
        parent::__construct($user, self::_get_props_config());
    }

    static function _get_props_config()
    {
        return array_merge(parent::_get_props_config(), [
            
        ]);
    }
}
