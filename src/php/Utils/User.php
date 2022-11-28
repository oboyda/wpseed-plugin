<?php

namespace PBOOT\Utils;

class Base extends \WPSEEDE\Utils\Base 
{
    static function getCurrentUser()
    {
        self::getCurrentUser('\PBOOT\Type\User');
    }

    static function getCurrentUserRole()
    {
        self::getCurrentUserRole('\PBOOT\Type\User');
    }
}