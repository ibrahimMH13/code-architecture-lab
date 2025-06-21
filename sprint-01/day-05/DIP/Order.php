<?php



interface Logger{
    public function log(array $data):void;
}

class FileLogger implements Logger{

    public function log(array $data) : void {
        echo "Logger " . implode(',',$data);
    }
}

class OrderSystem {

    public function __construct(protected Logger $logger){}

    public function process(){
        $this->logger->log(["Data"=>"order#124"]);
    }
}


 $order = new OrderSystem(new FileLogger());

 $order->process();