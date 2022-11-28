<?php

namespace PBOOT\Utils;

class Base extends \WPSEEDE\Utils\Base 
{
    static function getCurrentUser($type_class='\PBOOT\Type\User')
    {
        parent::getCurrentUser($type_class);
    }

    static function getCurrentUserRole($type_class='\PBOOT\Type\User')
    {
        parent::getCurrentUserRole($type_class);
    }
}