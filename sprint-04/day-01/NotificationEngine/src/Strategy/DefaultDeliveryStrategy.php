<?php

namespace Ibrahimmusabeh\NotificationEngine\Strategy;

use Ibrahimmusabeh\NotificationEngine\Contract\IDeliveryStrategy;
use Ibrahimmusabeh\NotificationEngine\Notification\{
    EmailNotifier,
    PushNotifier,
    SlackNotifier
};
class DefaultDeliveryStrategy implements IDeliveryStrategy{

    public function getNotifiersFor(string $event,array $data){

        return match ($event) {
            "invoice_paid" => [new SlackNotifier,new PushNotifier, new EmailNotifier],
             "default"=> [new EmailNotifier,new SlackNotifier],
        };
    }
}