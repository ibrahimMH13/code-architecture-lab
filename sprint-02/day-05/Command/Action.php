<?php



    interface Command{
        public function execute();
        public function undo();
    }

    class Light{

        public function turnOn(){
            echo "Turn On Light\n";
        }

        public function turnOff(){
            echo "Turn Off Light \n";
        }
    }

    class Door{
        public function open(){
            echo " Open door\n";
        }

        public function close(){
            echo "Close door\n";
        }
    }

    class Window{
        public function open(){
            echo " Open Window \n";
        }

        public function close(){
            echo "Close Window\n";
        }
    }


class LightCommand implements Command{

   public function __construct(protected Light $light){}

    public function execute(){
         $this->light->turnOn();
    }

    public function undo(){
        $this->light->turnOff();
    }
}

class DoorCommand implements Command{

    public function __construct(protected Door $door){}

    public function execute(){
        $this->door->open();
    }

    public function undo(){
        $this->door->close();
    }

}

class WindowCommand implements Command{
    public function __construct(protected Window $window){}

    public function execute(){
        $this->window->open();
    }

    public function undo(){
        $this->window->close();
    }

}


class SmartRemote {

    protected array $commands = [];
    protected array $history = [];

    public function setCommand(string $slot, Command $command): void {
        $this->commands[$slot] = $command;
    }

    public function press(string $slot): void {
        if (isset($this->commands[$slot])) {
            $command =  $this->commands[$slot];
            $command->execute();
            $this->history[] = ['slot'=>$slot,'command'=>$command];
            unset($this->commands[$slot]);
        }
    }

    public function undo(){
        if(empty($this->history)) return;
        $last  = array_pop($this->history);
        $last['command']->undo();
        $this->commands[$last['slot']] = $last['command'];
    }

}


$smartHome = new SmartRemote();
$light = new Light();
$window = new Window();
$door = new Door();

$smartHome->setCommand("A",new WindowCommand($window));
$smartHome->setCommand("B",new DoorCommand($door));
$smartHome->setCommand("C",new LightCommand($light));


$smartHome->press("A");
$smartHome->press("B");
$smartHome->press("A");
$smartHome->press("D");
$smartHome->press("D");
$smartHome->press("B");
$smartHome->press("D");
$smartHome->press("C");
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->undo();
$smartHome->press("D");
