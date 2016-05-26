<?php

namespace App\Controllers;

class ElevatorController {

    protected $elevator;

    public function __construct(\App\Models\ElevatorModel $model)
    {
        $this->elevator = $model;
    }

    public function loadCargo($humanCargo){
        $this->elevator->setHumanCargo($humanCargo);
        print("Loading cargo");
    }

}