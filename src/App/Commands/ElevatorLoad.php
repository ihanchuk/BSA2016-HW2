<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
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

        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);

        try{
            $this->controller->loadHumans($quantity,$floor);
        }catch (\Exception $error){
            $output->writeln('<error> '.$error->getMessage().'</error>');
            return false;
        }finally{
            Elevator::serializeModel();
            if(!$error) {
                $output->writeln('<info> '.Elevator::getParam("humanCargo").'passengers in Elevator </info>');
            }
        }
    }
}