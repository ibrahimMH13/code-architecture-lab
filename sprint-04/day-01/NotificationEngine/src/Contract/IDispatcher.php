<?php

namespace Ibrahimmusabeh\NotificationEngine\Contract;

interface IDispatcher {

    public function dispatch(mixed $data,array $notifierClasses);
    
}