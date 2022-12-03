<?php 

namespace PBOOT\Type;

class Post extends \WPSEEDE\Post
{
    public function __construct($post=null, $props_config=[])
    {
        parent::__construct($post, $props_config);
    }
}
