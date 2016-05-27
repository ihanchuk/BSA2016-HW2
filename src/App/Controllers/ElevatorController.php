<?php

namespace App\Controllers;

use \App\Models\ElevatorModel as Elevator;

/**
 * Class ElevatorController
 * @package App\Controllers
 */

/*
    Это не котроллер в понимании MVC. ElevatorController просто упращает управление моделью
    и стеком очереди. Контроллером в этом приложении выступают классы просстранства App\Commands
*/
class ElevatorController{
// @TODO: Перепроверить загрузку сериализации
// @TODO: Сделать phpDoc
    protected $el;
    protected $stack;


    public function __construct()
    {
        $this->el = Elevator::getInstance();
        $this->stack = new \App\Utils\Stack\ElevatorStack();
    }

    public  function getPath(){
        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.sz");

        return $path;
    }

    public function getStack(){
        $data = file_get_contents($path);
        $this->unserialize($data);
    }

    public function saveStack($stack)
    {
        file_put_contents($this->getPath(),$this->stack->serialize());
    }

    public function loadHumans($newPassengers,$floor){
        if ($newPassengers <=0) {
            throw new \Exception("Passengers must be > 0");
        }

        $maxCapacity = $this->el->getParam("maxHumans");
        $passengers = $this->el->getParam("humanCargo");

        if( ($passengers + $newPassengers) <= $maxCapacity){
            $data = ["passengers"=>$newPassengers,"floor"=>$floor];
            $this->stack->loadNewPassenger($data);
            $this->saveStack($this->stack);

            $this->el->setParam("humanCargo",$passengers + $newPassengers);
            $this->el->serializeModel();

        }else{
            throw new \Exception("::::::::::Elevator is jammed!::::::::");
        }
    }
}