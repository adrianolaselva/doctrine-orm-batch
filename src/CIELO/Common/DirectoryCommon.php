<?php

namespace CIELO\Common;

/**
 * Class DirectoryCommon
 * @package CIELO\Common
 */
class DirectoryCommon
{

    public static function dirEDIFilesToArray($basePath, $directoryEdi = ''){
        $files = scandir($basePath . DIRECTORY_SEPARATOR . $directoryEdi);
        foreach ($files as $key => $value) {
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
}