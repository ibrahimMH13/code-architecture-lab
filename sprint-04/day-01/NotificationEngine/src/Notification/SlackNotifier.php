<?php

namespace Ibrahimmusabeh\NotificationEngine\Notification;

use Ibrahimmusabeh\NotificationEngine\Contract\{
    INotifier,
    ILogger
};
use Ibrahimmusabeh\NotificationEngine\Logger\FileLogger;

class SlackNotifier implements INotifier {
    private ILogger $logger;
    public function __construct(){
        $this->logger = new FileLogger;
    }
    public function notify(array $data){
        $this->logger->log($data);
        echo "sending ...\n----->@". implode('|',$data)."#\n";
    }
}