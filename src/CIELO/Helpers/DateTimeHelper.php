<?php
/**
 * Created by PhpStorm.
 * User: Adriano
 * Date: 12/07/2016
 * Time: 20:01
 */

namespace CIELO\Helpers;

/**
 * Class DateTimeHelper
 * @package CIELO\Helpers
 */
class DateTimeHelper
{
    public static function formatDateYearTruncateToDateTime($dateTruncate, $format = 'Ymd'){
        try{
            if(strlen($dateTruncate) == 6){
                $dateTruncate = sprintf('20%s', $dateTruncate);
            }

            if(date($format, strtotime($dateTruncate)) == $dateTruncate)
                return $dateTime = new \DateTime($dateTruncate);
        }catch(\Exception $ex){
            throw new \Exception("Falha ao converter data");
        }
        return null;
    }

    public static function formatFromToDateTime($data, $fromFormat = 'Y-m-d H:m:s'){
        try{
            $dateTime = null;
            if(date($fromFormat, strtotime($data)) == $data){
                $dateTime = new \DateTime($data);
                return $dateTime;
            }
        }catch(\Exception $ex){
            throw new \Exception("Falha ao converter data");
        }
        return null;
    }

    public static function formatFromTo($data, $fromFormat = 'Y-m-d H:m:s', $toFormat = 'Y-m-d H:m:s'){
        try{
            $dateTime = null;
            if(date($fromFormat, strtotime($data)) == $data){
                $dateTime = new \DateTime($data);
                return $dateTime->format($data,$toFormat);
            }
        }catch(\Exception $ex){
            throw new \Exception("Falha ao converter data");
        }
        return null;
    }

}