<?php


abstract class Singleton{

    private static array $instances = [];
    private array $bag = [];
    private function __construct(){}
    public function __clone(){}
    public function __wakeup(){}

 final public static function create(){

    $class = static::class;
    if (empty(self::$instances[$class])) {
        self::$instances[$class] = new static();
    }
    return self::$instances[$class];
    }

    public function set($key,$value){

        $this->bag[$key] = $value; 
    }

    public function get($key){
        return $this->bag[$key]?? null;
    }
}

class LoggerSingleton extends Singleton{
    public function log($message) {
        file_put_contents('app.log', $message . "\n", FILE_APPEND); 
    }
}


$logger = LoggerSingleton::create();

$logger->log("hay this is first object");


$logger2 = LoggerSingleton::create();

$logger2->log("hay this is 2 object");