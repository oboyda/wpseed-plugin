<?php 

namespace PBOOT\Utils;

class Date 
{
    const DATE_FORMAT_SYS = 'Y-m-d';
    const TIME_FORMAT_SYS = 'H:i:s';
    const DATETIME_FORMAT_SYS = 'Y-m-d H:i:s';

    static function getDateFormat()
    {
        $format_opt = get_option('date_format');
        return $format_opt ? $format_opt : self::DATE_FORMAT_SYS;
    }

    static function getTimeFormat()
    {
        $format_opt = get_option('time_format');
        return $format_opt ? $format_opt : self::TIME_FORMAT_SYS;
    }

    static function getDateTimeFormat()
    {
        $format = self::getDateFormat() . ' ' . self::getTimeFormat();
        return trim($format);
    }

    static function formatDateTime($timestamp, $format=null)
    {
        if(!isset($format)) $format = self::getDateTimeFormat();

        $date_str = is_int($timestamp) ? gmdate(self::DATETIME_FORMAT_SYS, $timestamp) : $timestamp;
        $date = new \DateTime($date_str);
        $date->setTimezone(self::getTimezone());
        return $date->format($format);
    }

    static function formatDate($timestamp, $format=null)
    {
        if(!isset($format)) $format = self::getDateFormat();
        return self::formatDateTime($timestamp, $format);
    }
    
    static function getTimezone()
    {
        return new \DateTimeZone(wp_timezone_string());
    }

    static function getNowDate($format=null)
    {
        $date = new \DateTime("now");
        $date->setTimezone(self::getTimezone());
        return isset($format) ? $date->format($format) : $date;
    }

    static function getSysDateTime($timestamp=null)
    {
        return gmdate(self::DATETIME_FORMAT_SYS, $timestamp);
    }

    static function getSysDate($timestamp=null)
    {
        return gmdate(self::DATE_FORMAT_SYS, $timestamp);
    }

    static function parseAcfDateMeta($meta)
    {
        $date = [];
        $meta = strval($meta);
        if(strlen($meta) === 8)
        {
            $date[] = substr($meta, 0, 4);
            $date[] = substr($meta, 4, 2);
            $date[] = substr($meta, 6, 2);
        }
        return implode('-', $date);
    }
}
