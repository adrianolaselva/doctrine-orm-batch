<?php

namespace CIELO\Common;
use Exception;

/**
 * Class DirectoryCommon
 * @package CIELO\Common
 */
class DirectoryCommon
{

    public static function dirEDIFilesToArray($basePath, $directoryEdi = ''){
        $result = [];
        $files = scandir($basePath . DIRECTORY_SEPARATOR . $directoryEdi);
        foreach ($files as $key => $value) {
            if(strpos(strtolower($value), ".wrk") !== false)
                continue;

            if (!in_array($value, [".", "..",".gitkeep",".gitignore"])) {

                if (is_dir($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value)){
                    $result[$value] = DirectoryCommon::dirEDIFilesToArray($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value);
                    continue;
                }
                $result[] = [
                    'name' => $value,
                    'path' => DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                    'fullName' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value,
                    'fullPath' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                    'hashFile' => hash_file('sha1', $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value)
                ];
            }
        }
        return $result;
    }

    public static function dirEDIFilesAllToArray($basePath, $directoryEdi = ''){
        $result = [];
        $files = scandir($basePath . DIRECTORY_SEPARATOR . $directoryEdi);
        foreach ($files as $key => $value) {

            if (!in_array($value, [".", "..",".gitkeep",".gitignore"])) {

                if (is_dir($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value)){
                    $result[$value] = DirectoryCommon::dirEDIFilesToArray($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value);
                    continue;
                }

                if(!is_file($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value))
                    continue;

                $result[] = [
                    'name' => $value,
                    'path' => DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                    'fullName' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value,
                    'fullPath' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                    'hashFile' => hash_file('sha1', $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $value)
                ];
            }
        }
        return $result;
    }

    public static function getFileRand($basePath, $directoryEdi = ''){
        try{
            $files = [];
            $filesTemp = scandir($basePath . DIRECTORY_SEPARATOR . $directoryEdi);

            foreach ($filesTemp as $key => $value) {

                if(strpos(strtolower($value), ".wrk") !== false)
                    continue;

                if (in_array($value, [".", "..",".gitkeep",".gitignore"]))
                    continue;

                $files[] = $value;
            }

            if(empty($files[0]))
                return null;

            if(!is_file($basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $files[0]))
                return null;

            return [
                'name' => $files[0],
                'path' => DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                'fullName' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $files[0],
                'fullPath' => $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR,
                'hashFile' => hash_file('sha1', $basePath . DIRECTORY_SEPARATOR . $directoryEdi . DIRECTORY_SEPARATOR . $files[0])
            ];
        }catch (Exception $ex){
            throw new Exception("Arquivo já em uso");
        }
    }


}