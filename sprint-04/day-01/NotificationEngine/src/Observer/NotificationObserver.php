<?php

namespace Ibrahimmusabeh\NotificationEngine\Observer;

use Ibrahimmusabeh\NotificationEngine\Dispatcher\NotificationDispatcher;
use Ibrahimmusabeh\NotificationEngine\Contract\{
    IObserver,
    IObserverable
};
use  Ibrahimmusabeh\NotificationEngine\Service\NotificationService;
use  Ibrahimmusabeh\NotificationEngine\Strategy\DefaultDeliveryStrategy;
class NotificationObserver implements IObserver{

    public function update(array $data){

       $dispatcher = new NotificationDispatcher();
       $strategy = new DefaultDeliveryStrategy();
       $service = new NotificationService($strategy, $dispatcher);
       $service->send($data['event'], $data);

    }

}