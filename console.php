<?php

session_start();

require __DIR__ . '/vendor/autoload.php';
use \App\Commands\Test;
use \App\Prototype\ProtoApp;


$app = new ProtoApp("Elevator AI","0.1");

$app->configureApp([
    "locked"=>false,
    "humanCargo"=>0,
    "curentFloor"=>1,
    "minFloor"=>1,
    "maxFloor"=>9,
    "maxHumans"=>4
]);


$app->run();





