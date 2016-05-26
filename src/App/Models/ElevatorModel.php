<?php

namespace App\Models;

class ElevatorModel{
    protected static $elevatorData=[];
    use \App\Utils\Traits\Serializer;

    public static function getParam($param)
    {
        return self::$elevatorData[$param];
    }

    public static function setParam($param,$val)
    {
        self::$elevatorData[$param]=$val;
    }

    public static function reset($conf){
        var_dump($conf);
        self::$elevatorData = $conf;
        self::serializeModel();
    }

    public static function loadHumans($humans)
    {
        $kvo = self::$elevatorData["humanCargo"] + $humans;
        if ($kvo > 4) {
            self::setParam("loocked",true);
            throw new \Exception("Overloaded and stuck! Please, run 'elevator:repair to unlock' ");
            return false;
        }else{
            self::$elevatorData["humanCargo"]=$kvo;
            return true;
        }
    }
}