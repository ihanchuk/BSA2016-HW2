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
    public $el;
    public $stack;


    public function __construct()
    {
        $this->el = Elevator::getInstance();
        $this->stack = new \App\Utils\Stack\ElevatorStack();
        $this->stack->getStack();

    }

    public function unloadHumans(){
        if ($this->stack->count() > 0){

            if(!$this->el->getParam("locked")) {
                $data = $this->stack->pop();
                $this->stack->saveStack();

                $allHumans =$this->el->getParam("humanCargo");

                $passengersLeft= $allHumans - $data["passengers"];
                $passengersOut = $data["passengers"];
                $floor = $data["floor"];

                $this->stack->saveStack();
                $this->el->serializeModel();

                $this->el->setParam("humanCargo",$passengersLeft);
                $this->el->setParam("curentFloor",$floor);

                return ("<header>Unloading {$passengersOut} passengers on {$floor} floor out of the elevator. Pasengers left -  {$passengersLeft} </header>");
            }else{
                throw new \Exception("Elevator is stuck!! run elevator:repair to unlock");
            }

        }else{
            $this->el->setParam("locked",true);
            $this->el->serializeModel();
            throw new \Exception("All humans are unloaded.Elevator is stuck! run elevator:repair");
        }

    }

    public function loadHumans($newPassengers,$floor){

        $maxCapacity = $this->el->getParam("maxHumans");
        $passengers = $this->el->getParam("humanCargo");

        $minFloor = $this->el->getParam("minFloor");
        $maxFloor = $this->el->getParam("maxFloor");

        if ($newPassengers <=0) {
            throw new \Exception("Passengers must be > 0");
        }

        if($floor > $maxFloor || $floor <$minFloor){
            throw new \Exception("Floor must set the right way!!");
        }

        if( ($passengers + $newPassengers) <= $maxCapacity){
            $data = ["passengers"=>$newPassengers,"floor"=>$floor];
            $totalPassengers = $passengers + $newPassengers;
            $this->stack->loadNew($data);
            $this->stack->saveStack($this->stack);

            $this->el->setParam("humanCargo",$passengers + $newPassengers);
            $this->el->serializeModel();

            return ("<header>Loaded {$newPassengers}. Passengers in elevator - {$totalPassengers}  </header>");

        }else{
            $this->el->setParam("locked",true);
            $this->el->serializeModel();
            throw new \Exception(":::::::::: Elevator is stuck! to unlock execute elevator:repair ::::::::");
        }
    }

    public function debugStack(){
        return $this->stack;
    }
}