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
            return doubleval($number);
        }
        return doubleval($default);
    }

    public static function formatDecimalDiv($number, $precision = 2, $default = 0){
        if(is_numeric($number)){
            return doubleval($number/100);
        }
        return doubleval($default);
    }

    public static function toInt($number, $default = 0){
        if(is_numeric($number)){
            return intval(number_format($number));
        }
        return intval($default);
    }
}