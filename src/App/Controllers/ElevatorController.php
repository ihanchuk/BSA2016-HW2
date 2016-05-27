<?php

namespace App\Controllers;

use \App\Models\ElevatorModel as Elevator;

class ElevatorController{

    protected $el;


    public function __construct()
    {
        $this->el = Elevator::getInstance();
    }

    public function loadHumans($newPassengers,$floor){
        if ($newPassengers <=0) {
            throw new \Exception("Passengers must be > 0");
        }

        $maxCapacity = $this->el->getParam("maxHumans");
        $passengers = $this->el->getParam("humanCargo");

        if( ($passengers + $newPassengers) <= $maxCapacity){
            $this->el->setParam("humanCargo",$passengers + $newPassengers);
            
        }else{
            throw new \Exception("::::::::::Elevator is jammed!::::::::");
        }

    }

}