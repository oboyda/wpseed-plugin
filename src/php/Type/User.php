<?php 

namespace PBOOT\Type;

class User extends \WPSEED\User
{
    public function __construct($user=null)
    {
        parent::__construct($user);
    }

    static function _get_props_config()
    {
        return [
        ];
    }

    /* ------------------------- */

    public function getRole()
    {
        return $this->get_role();
    }
}
