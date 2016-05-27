<?php

namespace App\Controllers;

class ElevatorController{

    protected $elevator;
    protected $limit;
    protected $paengers = [];

    public function __construct(\App\Models\ElevatorModel $model)
    {
        $this->elevator = $model;
    }

    public function loadCargo($humanCargo){
        $this->elevator->setHumanCargo($humanCargo);
        print("Loading cargo");
    }

}