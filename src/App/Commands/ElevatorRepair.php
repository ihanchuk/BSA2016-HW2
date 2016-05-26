<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \App\Models\ElevatorModel as Elevator;

class ElevatorRepair extends Command {

    public function __construct($defaults){
        parent::__construct();
        $this->defaults = $defaults;
    }

    protected function configure()
    {
        $this->setName("elevator:repair")
            ->setDescription("Unload all humans and restart elevator");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Elevator::reset($this->defaults);
        Elevator::serializeModel();
    }
}