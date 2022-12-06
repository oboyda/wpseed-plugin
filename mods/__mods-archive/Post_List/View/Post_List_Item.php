<?php

namespace PBOOT\Mod\Post_List\View;

class Post_List_Item extends \PBOOT\View\View 
{
    public $item;

    public function __construct($args)
    {
        parent::__construct($args, [

            'item' => null,
            'type_class' => '\PBOOT\Type\Post'
        ]);

        $type_class = $this->args['type_class'];
        $this->item = (is_int($this->args['item']) && class_exists($type_class)) ? new $type_class($this->args['item']) : $this->args['item'];
    }
}
