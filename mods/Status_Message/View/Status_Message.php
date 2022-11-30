<?php

namespace PBOOT\Mod\Status_Message\View;

class Status_Message extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [

            'type' => 'success',
            'message' => ''
        ]);
    }
}
