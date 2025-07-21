<?php
namespace Ibrahimmusabeh\NotificationEngine\Logger;

use Ibrahimmusabeh\NotificationEngine\Contract\ILogger;

class FileLogger implements ILogger{

    public function log(array $data){
        echo "\nlogging...\n";
        file_put_contents("app.log",$data,FILE_APPEND);
    }
}