<?php

namespace App\Commands;

// @TODO: Использовать фабрику для создания граф. виджетов
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use \App\Models\ElevatorModel as Elevator;
use \App\Controllers\ElevatorController as Controller;

final class ElevatorMove extends Command {
// @TODO: Наконецто закончить этот гребанный класс
// @TODO: Добавить прогресс бар для отображения анимации
//// @TODO: Создай новый стек лифта и выгружай пасажиров. Проверяй к-во выгруженных. Если что, кинь кастомный эксепшн
    public $controller;

    public function __construct(){
        parent::__construct();
        $this->controller = new Controller();
    }

    protected function configure()
    {
        $quantity = 0;
        $this->setName("elevator:move")
            ->setDescription("Moves humans in Elevator")
            ->setHelp(<<<EOT
            Moves humans in elevator to some other floor 
            Usage:
            
            <info>php console.php elevator:move <env></info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);

        try{
           $mes=  $this->controller->unloadHumans();
        }catch (\Exception $error){
            $output->writeln('<error> '.$error->getMessage().'</error>');
            return false;
        }finally{
            Elevator::serializeModel();
            if(!$error) {
                $output->writeln($mes);
            }
        }

    }
}