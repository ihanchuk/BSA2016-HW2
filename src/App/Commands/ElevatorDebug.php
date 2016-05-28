<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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

        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);

        $locked =(Elevator::getParam("locked")) ? 'locked' : 'not locked';

        $output->writeln('<error> :::::::::::::::::::  !!! Debuging Elevator !!! :::::::::::::::::::</error>');
        $output->writeln(" ");

        $output->writeln('<header>Humans:: '.Elevator::getParam("humanCargo").'</header>');
        $output->writeln('<header>Locked:: '.$locked.'</header>');
        $output->writeln('<header>Floor:: '.Elevator::getParam("curentFloor").'</header>');

        $output->writeln(" ");
        $output->writeln('<question> :::::::::::::::::::  !!! Dumping RAW Data !!! :::::::::::::::::::</question>');

        var_dump(Elevator::dump());

        $output->writeln('<question> :::::::::::::::::::  !!! Dumping Raw Stack Data !!! :::::::::::::::::::</question>');

        $stack = new \SplStack();

        $dir = getcwd();
        $path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data.sz");

        $stack->unserialize(file_get_contents($path));

        $output->writeln('<header>Objects in Stack.'.$stack->count().'</header>');
        foreach ($stack as $el){
            var_dump($el);
            $output->writeln('____________________________________________');
        }
    }
}