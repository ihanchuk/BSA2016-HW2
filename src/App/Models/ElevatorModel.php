<?php

namespace App\Models;

class ElevatorModel{
    protected static $elevatorData=[];
    protected static $defaultData=[];

    use \App\Utils\Traits\Serializer;
    use \App\Utils\Traits\SingleTon;

    public function getParam($param)
    {
        return self::$elevatorData[$param];
    }

    public  function setParam($param,$val)
    {
        self::$elevatorData[$param]=$val;
    }

    public  function setDefault($default)
    {
        self::$defaultData = $default;
    }

    public static function reset(){
        self::$elevatorData = self::$defaultData;
        self::serializeModel();
    }

    public  function dump(){
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