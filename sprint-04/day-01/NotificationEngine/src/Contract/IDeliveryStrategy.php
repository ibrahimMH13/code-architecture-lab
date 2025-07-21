<?php

namespace Ibrahimmusabeh\NotificationEngine\Contract;

interface IDeliveryStrategy{

    public function getNotifiersFor(string $event,array $data);
}