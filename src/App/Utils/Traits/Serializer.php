<?php

namespace App\Utils\Traits;

trait Serializer{

    public static function getPath(){
        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");

        return $path;
    }

    public static function serializeModel(){
        $res = file_put_contents(self::getPath(),serialize(self::$elevatorData));
        return $res;
    }

    public static function loadModel(){
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");
        $data = unserialize(file_get_contents(self::getPath()));
        if($data){
            self::$elevatorData = $data;
        }else{
            throw new \Exception("Failed loading data!");
        }
    }
}