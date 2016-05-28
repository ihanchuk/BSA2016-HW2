<?php
namespace App\Utils\Stack;
// @TODO: Сделать phpDoc.
class ElevatorStack extends \SplStack{

    protected $path;
    protected $fileName = "data.sz";

    public function __construct()
    {
        $dir = getcwd();
        $this->path = ($dir.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR.$this->fileName);
    }

    public function getNext(){
        return $this->shift();
    }

    public function getPath(){
        return $this->path;
    }

    public function hardResetStack()
    {
        unlink($this->path);

        while($this->valid()) {
            $stack->pop();
        }
        $this->saveStack();
    }

    public function getStack(){
        //@TODO используй спл!
        $data = file_get_contents($this->path);
        $this->unserialize($data);
    }

    public function saveStack()
    {
        file_put_contents($this->getPath(),$this->serialize());
    }

    public function loadNew(Array $passenger){
        if(isset($passenger)){
            $this->push($passenger);
        }
    }
}