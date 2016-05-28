<?php

namespace App\Utils\Traits;

trait Serializer{

    public static function getPath(){
        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");

        return $path;
    }

    public static function serializeModel(){
        // @TODO:  проверить файл на возможность  записи.
//        $res = file_put_contents(self::getPath(),serialize(self::$elevatorData));
//        return $res;

        if (is_writable(self::getPath())){
            file_put_contents(self::getPath(),serialize(self::$elevatorData));
        }else{
            throw new \Exception("Data not writable");
        }
    }

    public static function loadModel(){
        // @TODO:  проверить файл на доступ.

        if (is_readable(self::getPath())){
            $data = unserialize(file_get_contents(self::getPath()));
            self::$elevatorData = $data;
        }else{
            throw new \Exception("Data no readable");
        }
    }
}