<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \App\Models\ElevatorModel as Elevator;
use \App\Controllers\ElevatorController as Controller;

class ElevatorLoad extends Command {

    private $controller;

    public function __construct(){
        parent::__construct();
        $this->controller = new Controller();
    }

    protected function configure()
    {
        $quantity = 0;
        $this->setName("elevator:load")
            ->setDescription("Loads humans to elevator <int>")
            ->addArgument(
                'quantity',
                InputArgument::REQUIRED,
                'How many humans to load)?'
            )
            ->addArgument(
                'floor',
                InputArgument::REQUIRED,
                'Floor?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $quantity = intval($input->getArgument('quantity'));
        $floor = intval($input->getArgument('floor'));

        try{
            $this->controller->loadHumans($quantity,$floor);
        }catch (\Exception $e){
            $output->writeln('<header>Elevator:: '.$e->getMessage().'</header>');
            return false;
        }finally{
            Elevator::serializeModel();
            if(!$e) $output->writeln('<header>Loaded '.Elevator::getParam("humanCargo").'</header>');
        }
    }
}