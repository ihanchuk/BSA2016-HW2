<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use \App\Models\ElevatorModel as Elevator;
// @TODO: Сделать phpDoc
class ElevatorRepair extends Command {
// @TODO: Если уж лифт выгружается, надо обнулить его стек очереди
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
        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);
        $output->writeln('<question> :::::::::::::::::::  !!! Fixing this Elelevator !!! :::::::::::::::::::</question>');

//        $progressBar = new ProgressBar($output, 100);
//
//        for ($i = 0; $i<100; $i++) {
//            $progressBar->advance();
//            usleep(100000);
//        }
//
//        $progressBar->finish();
        $output->writeln('');

        Elevator::setDefault($this->defaults);
        Elevator::reset();

        // @TODO: Вот тут сделать обнуление стека лифта.
        $stack = new \App\Utils\Stack\ElevatorStack();;
        $stack ->hardResetStack();

        $output->writeln('<info> \'Stack\' and \'Elevator\' has been  reverted to initial state</info>');
        $output->writeln('');
        $output->writeln('<question> :::::::::::::::::::  !!! Elevator is now functional !!! :::::::::::::::::::</question>');

    }
}