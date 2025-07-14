<?php



abstract class Facade{
  
  protected static array $instances = [];
  abstract protected static function getAccessor():string;

  public static function __callStatic($method,$params){

    $accessor = static::getAccessor();

    if (!isset(static::$instances[$accessor])) {
        static::$instances[$accessor] = new $accessor;
    }
    return static::$instances[$accessor]->$method(...$params);
    }
}

class Logger{
    public function log(string $txt){
        file_put_contents('app.log', $txt . PHP_EOL, FILE_APPEND);
    }
}

class LogFacade extends Facade{

    protected static function getAccessor():string{
        return Logger::class;
    }
}


LogFacade::log("hello, Man, 5");