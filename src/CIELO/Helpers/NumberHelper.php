<?php

namespace CIELO\Helpers;

/**
 * Class NumberHelper
 * @package CIELO\Helpers
 */
class NumberHelper
{
    public static function formatDecimal($number, $precision = 2, $default = 0){
        if(is_numeric($number)){
            return number_format($number, $precision);
        }
        return $default;
    }

    public static function formatDecimalDiv($number, $precision = 2, $default = 0){
        if(is_numeric($number)){
            return number_format($number/100, $precision);
        }
        return $default;
    }

    public static function toInt($number, $default = 0){
        if(is_numeric($number)){
            return number_format($number);
        }
        return $default;
    }
}