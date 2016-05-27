<?php

namespace App\Models;
// @TODO: Сделать пхп док
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
}