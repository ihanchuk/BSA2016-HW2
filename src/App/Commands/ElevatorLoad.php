<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \App\Models\ElevatorModel as Elevator;

class ElevatorLoad extends Command {

    private $elevator;

    public function __construct(){
        parent::__construct();
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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qt = intval($input->getArgument('quantity'));
        try{
            Elevator::loadHumans($qt);
        }catch (\Exception $e){
            $output->writeln('<header>Elevator:: '.$e->getMessage().'</header>');
            return false;
        }finally{
            Elevator::serializeModel();
            if(!$e) $output->writeln('<header>Loaded '.Elevator::getParam("humanCargo").'</header>');
        }
    }
}