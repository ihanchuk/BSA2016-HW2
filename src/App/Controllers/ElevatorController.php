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
        $this->getStack();

    }

    public function getStack(){
        //@TODO используй спл!
        $data = file_get_contents($this->stack->getPath());
        $this->stack->unserialize($data);
    }

    public function saveStack($stack)
    {
        file_put_contents($this->stack->getPath(),$this->stack->serialize());
    }

    public function hardResetStack()
    {
        unset($this->stack);
        $this->stack = new \App\Utils\Stack\ElevatorStack();
        file_put_contents($this->stack->getPath(),$this->stack->serialize());
    }


    public function loadHumans($newPassengers,$floor){

        $maxCapacity = $this->el->getParam("maxHumans");
        $passengers = $this->el->getParam("humanCargo");

        $minFloor = $this->el->getParam("minFloor");
        $maxFloor = $this->el->getParam("maxFloor");

        if ($newPassengers <=0) {
            throw new \Exception("Passengers must be > 0");
        }

        print("floor - ".$floor);

        if($floor > $maxFloor || $floor <$minFloor){
            throw new \Exception("Floor must set the right way!!");
        }

        if( ($passengers + $newPassengers) <= $maxCapacity){
            $data = ["passengers"=>$newPassengers,"floor"=>$floor];
            $this->stack->loadNew($data);
            $this->saveStack($this->stack);

            $this->el->setParam("humanCargo",$passengers + $newPassengers);
            $this->el->serializeModel();

        }else{
            throw new \Exception("::::::::::Elevator is jammed!::::::::");
        }
    }

    public function debugStack(){
        return $this->stack;
    }
}