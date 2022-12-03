<?php 

namespace PBOOT\Type;

class User extends \WPSEEDE\User 
{
    public function __construct($user=null, $props_config=[])
    {
        parent::__construct($user, $props_config=[]);
    }
}
