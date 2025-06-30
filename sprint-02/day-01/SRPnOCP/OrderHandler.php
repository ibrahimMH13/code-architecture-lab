<?php

interface IOrderManager {

    public function notify();
    public function handleOrder(array $order):self;

}

interface notifier {
    public function notify(array $order);
}

class EmailNotifier implements notifier{
    public function notify(array $order){
        mail($order['email'], 'Order Confirmation', 'Thank you for your order!');
        echo "sending email notification ...\n";
    }
}

class OrderManager implements IOrderManager {
    protected array $order = [];
    public function __construct(protected notifier $notifier){}

    public function handleOrder(array $order):self{
            $this->order = $order;
            echo "process order \n";
            return $this;
    }

    public function notify(){

         return $this->notifier->notify($this->order);
    }
}
