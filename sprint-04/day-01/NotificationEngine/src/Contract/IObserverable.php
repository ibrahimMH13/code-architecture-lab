<?php
namespace Ibrahimmusabeh\NotificationEngine\Contract;

use Ibrahimmusabeh\NotificationEngine\Contract\IObserver;

interface IObserverable{

    public function attach(IObserver $observer);
    public function detach(IObserver $observer);
}