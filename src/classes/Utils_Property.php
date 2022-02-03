<?php

namespace HSP;

class Utils_Property
{
    static function formatNumber($num, $decimal=0)
    {
        return number_format($num, $decimal, '.', ',');
    }

    static function getCurrencySymbol()
    {
        return '&euro;';
    }

    static function getLengthUnit()
    {
        return 'm';
    }

    static function getAreaUnit()
    {
        return 'm&sup2;';
    }

    static function formatPrice($price)
    {
        return self::getCurrencySymbol() . self::formatNumber($price);
    }

    static function formatArea($area)
    {
        return self::formatNumber($area) . ' ' . self::getAreaUnit();
    }
}
