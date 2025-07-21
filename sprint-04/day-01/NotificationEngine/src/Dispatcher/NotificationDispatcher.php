<?php

namespace Ibrahimmusabeh\NotificationEngine\Dispatcher;
use Ibrahimmusabeh\NotificationEngine\Notification\{
    EmailNotifier,
    PushNotifier,
    SlackNotifier
};

use Ibrahimmusabeh\NotificationEngine\Contract\IDispatcher;

class NotificationDispatcher implements IDispatcher{

    public function dispatch(mixed $data,array $notifierClasses){
        foreach($notifierClasses as $className){
            (new $className)->notify($data);
        }
    }
}