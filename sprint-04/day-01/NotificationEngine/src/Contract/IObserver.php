<?php

namespace Ibrahimmusabeh\NotificationEngine\Contract;


interface IObserver{

    public function update(array $data);
    
}