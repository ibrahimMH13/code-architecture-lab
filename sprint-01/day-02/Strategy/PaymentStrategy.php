<?php

interface IPayment{

    public function process(float $amount):void;
}

interface IPaymentGateway {
    public function pay(float $amount);
}

class PayPal implements IPaymentGateway{

    public function pay(float $amount){
        echo "Paypal process the payment now";
    }
}

class CreditCard implements IPaymentGateway{

    public function pay(float $amount){
        echo "CC process the payment now";
    }
}

class Wise implements IPaymentGateway{

    public function pay(float $amount){
        echo "Wise process the payment now";
    }
}

class Stripe implements IPaymentGateway{

    public function pay(float $amount){
        echo "Stripe process the payment now";
    }
}

class PaymentManager implements IPayment{

    public function __construct(private IPaymentGateway $paymentGetway){}
    public function process(float $amount) : void {
       $this->paymentGetway->pay($amount);
    }

    public function setPaymentGetway(IPaymentGateway $paymentGetway){
        $this->paymentGetway = $paymentGetway;
    }
    
}

// test it

 
$pm = new PaymentManager(new CreditCard());
$pm->process(34);
echo "\n";
$pm->setPaymentGetway(new PayPal());
$pm->process(44);
echo "\n";