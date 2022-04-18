<?php 

namespace TILEC;

use TILEC\Type\Product;

class Utils_Settings 
{
    static function getTileSize()
    {
        return (int)tilec_get_option('tile_size', 15);
    }

    static function getGridMinX($tiles=false)
    {
        $grid_min_x = (int)tilec_get_option('grid_min_x', 450);
        return $tiles ? ceil($grid_min_x / self::getTileSize()) : $grid_min_x;
    }

    static function getGridMinY($tiles=false)
    {
        $grid_min_y = (int)tilec_get_option('grid_min_y', 450);
        return $tiles ? ceil($grid_min_y / self::getTileSize()) : $grid_min_y;
    }

    static function getGridMaxX($tiles=false)
    {
        $grid_max_x = (int)tilec_get_option('grid_max_x', 4500);
        return $tiles ? ceil($grid_max_x / self::getTileSize()) : $grid_max_x;
    }

    static function getGridMaxY($tiles=false)
    {
        $grid_max_y = (int)tilec_get_option('grid_max_y', 4500);
        return $tiles ? ceil($grid_max_y / self::getTileSize()) : $grid_max_y;
    }
}
