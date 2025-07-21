<?php


require 'vendor/autoload.php';

use Ibrahimmusabeh\NotificationEngine\{
    NewsAgency,
    Observer\NotificationObserver,
    Strategy\DefaultDeliveryStrategy,
    Service\NotificationService,
    Dispatcher\NotificationDispatcher
};
$na = new NewsAgency;
$na->attach(new NotificationObserver);

$na->notify([
    "event" =>"invoice_paid",
    "name"=>"Ibrahim I.I. Musabeh",
    "Year" =>2025,
    "age" =>":P"
]);

