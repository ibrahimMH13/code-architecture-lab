<?php


namespace Ibrahimmusabeh\NotificationEngine\Service;

use Ibrahimmusabeh\NotificationEngine\Contract\{
    IDeliveryStrategy,
    IDispatcher
};

class NotificationService {
    
    public function __construct(private IDeliveryStrategy $deliveryStrategy,private IDispatcher $dispatcher){}

    public function send(string $event,array $data){
    
        $notifiers = $this->deliveryStrategy->getNotifiersFor($event, $data);
    
        $this->dispatcher->dispatch($data, $notifiers);  
    
    }
}