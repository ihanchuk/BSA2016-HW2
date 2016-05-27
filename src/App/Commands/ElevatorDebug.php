<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use App\Models\ElevatorModel as Elevator;


class ElevatorDebug extends Command {


    protected function configure()
    {
        $this->setName("elevator:debug")
            ->setDescription("Debugs Elevator Object");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.ob");
        $res = unserialize(file_get_contents($path));

        $locked =(Elevator::getParam("locked")) ? 'locked' : 'not locked';

        $output->writeln('<header>Humans:: '.Elevator::getParam("humanCargo").'</header>');
        $output->writeln('<header>Locked:: '.$locked.'</header>');
        $output->writeln('<header>Floor:: '.Elevator::getParam("curentFloor").'</header>');

        var_dump(Elevator::dump());
    }
}