<?php

namespace Ibrahimmusabeh\NotificationEngine;

use Ibrahimmusabeh\NotificationEngine\Contract\{
    IObserverable,
    IObserver,
    INotifier
};

class NewsAgency implements IObserverable, INotifier{

    protected array $observers = [];

    public function attach(IObserver $obj){
        $this->observers[] = $obj; 
    }

    public function detach(IObserver $obj){
        $this->observers = array_filter($this->observers,fn($o)=> $o !== $obj);
    }

    public function notify(array $data){
        foreach($this->observers as $obj){
           $obj->update($data);
        }
    }
}