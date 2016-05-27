<?php

namespace App\Models;

class ElevatorModel{
    protected static $elevatorData=[];
    protected static $defaultData=[];

    use \App\Utils\Traits\Serializer;

    public static function getParam($param)
    {
        return self::$elevatorData[$param];
    }

    public static function setParam($param,$val)
    {
        self::$elevatorData[$param]=$val;
    }

    public static function setDefault($default)
    {
        self::$defaultData = $default;
    }

    public static function reset(){
        self::$elevatorData = self::$defaultData;
        self::serializeModel();
    }

    public static function dump(){
        return self::$elevatorData;
    }

    public static function loadHumans($humans)
    {
        $kvo = self::$elevatorData["humanCargo"] + $humans;
        if ($kvo > 4) {
            self::setParam("locked",true);
            throw new \Exception("Overloaded and stuck! Please, run 'elevator:repair to unlock' ");
            return false;
        }else{
            self::$elevatorData["humanCargo"]=$kvo;
            return true;
        }
    }
}