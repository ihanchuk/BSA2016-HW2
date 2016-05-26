<?php
namespace App\Prototype;

use App\Models\ElevatorModel;
use Symfony\Component\Console\Application as ConsoleApp;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Factory\ElevatorFactory;
use App\Controllers\ElevatorController;

use \App\Commands\Fibo;
use \App\Commands\ElevatorLoad;
use \App\Commands\ElevatorMove;
use \App\Commands\ElevatorDebug;
use \App\Commands\ElevatorRepair;

/**
 * Class ProtoApp
 * @package App\Prototype
 */
class ProtoApp extends ConsoleApp{

    protected $elevatorDefaults;

    public function __construct($name, $version)
    {
        parent::__construct($name, $version);

        $this->out = new ConsoleOutput();
        $this->consoleWidgets["progressBar"] = new ProgressBar($this->out, 10);
    }

    public function configureApp($conf){

        try{
            ElevatorModel::loadModel();
        }catch (\Exception $e){
            print($e->getMessage());
        }finally{
            if (isset($e)){
                ElevatorModel::reset($conf);
            }
        }

        $this->add(new Fibo());
        $this->add(new ElevatorLoad());
        $this->add(new ElevatorMove());
        $this->add(new ElevatorDebug());
        $this->add(new ElevatorRepair($this->elevatorDefaults));

        }

}