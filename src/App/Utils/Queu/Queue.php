<?php

namespace App\Utils\Queue;

class ElevatorQueue extends SplQueue{

        public function __construct()
        {
            print("I am constructed");
        }
}