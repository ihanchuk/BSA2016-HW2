<?php

namespace App\Utils\Traits;
// @TODO: Сделать phpDoc
trait Serializer{
// @TODO: Переписать сериализацию с использованием SPLFile
// @TODO: Uploaded files are not removed here.
    public static function getPath(){
        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");

        return $path;
    }

    public static function serializeModel(){
        // @TODO: Через спл проверить файл на возможность чтения записи.
        $res = file_put_contents(self::getPath(),serialize(self::$elevatorData));
        return $res;
    }

    public static function loadModel(){
        // @TODO: Через спл проверить файл на доступ.
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");
        $data = unserialize(file_get_contents(self::getPath()));
        if($data){
            self::$elevatorData = $data;
        }else{
            throw new \Exception("Failed loading data!");
        }
    }
}