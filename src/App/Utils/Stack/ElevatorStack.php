<?php
namespace App\Utils\Stack;
// @TODO: Сделать phpDoc.
class ElevatorStack extends \SplStack{

    public function getNextPassenger(){
        return $this->shift();
    }

    public function loadNewPassenger(Array $passenger){
        if(isset($passenger)){
            $this->push($passenger);
        }
    }
}