<?php

namespace App\Commands;
// @TODO: Перепроверить импорты
// @TODO: Использовать фабрику для создания граф. виджетов
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ElevatorMove extends Command {
// @TODO: Наконецто закончить этот гребанный класс
// @TODO: Добавить прогресс бар для отображения анимации
//// @TODO: Создай новый стек лифта и выгружай пасажиров. Проверяй к-во выгруженных. Если что, кинь кастомный эксепшн
    protected function configure()
    {
        $quantity = 0;
        $this->setName("elevator:move")
            ->setDescription("Moves humans to elevator <int>")
            ->setDefinition(array(
                new InputOption('qt', 's', InputOption::VALUE_REQUIRED, 'Number of humans to load. 4 is max value', $quantity),
            ))
            ->setHelp(<<<EOT
Moves humans in elevator to some other floor 
Usage:

<info>php console.php elevator:move -fl 10 <env></info>

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $header_style = new OutputFormatterStyle('white', 'green', array('bold'));
        $output->getFormatter()->setStyle('header', $header_style);

        $start = intval($input->getOption('start'));
        $stop  = intval($input->getOption('stop'));

        if ( ($start >= $stop) || ($start < 0) ) {
            throw new \InvalidArgumentException('Stop number should be greater than start number');
        }

        $output->writeln('<header>Fibonacci numbers between '.$start.' - '.$stop.'</header>');

        $xnM2 = 0; // set x(n-2)
        $xnM1 = 1;  // set x(n-1)
        $xn = 0; // set x(n)
        $totalFiboNr = 0;
        while ($xnM2 <= $stop)
        {
            if($xnM2 >= $start)  {
                $output->writeln('<header>'.$xnM2.'</header>');
                $totalFiboNr++;
            }
            $xn = $xnM1 + $xnM2;
            $xnM2 = $xnM1;
            $xnM1 = $xn;

        }
        $output->writeln('<header>Total of Fibonacci numbers found = '.$totalFiboNr.' </header>');
    }
}