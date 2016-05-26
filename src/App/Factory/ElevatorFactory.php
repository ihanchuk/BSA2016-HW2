<?php

namespace App\Factory;

use App\Models\ElevatorModel as Elevator;

final class ElevatorFactory{

    public function __construct()
    {
        session_start();
    }


    private function createElevator(){
        $res = new ElevatorModel();

        $res->setCurentFloor(0);
        $res->setIsLocked(false);
        $res->setHumanCargo(0);
        $res->setMaxFloor(9);
        $res->setMinFloor(1);

        return $res;
    }

    public function loadOrCreateElevator(){
        if(!Elevator::loadModel()){
            print("Fialed loading data!");
        }

    }

}