<?php

interface PaymentMethod {
    public function pay($amount);
}

class CreditCardPayment implements PaymentMethod {
    public function pay($amount) {
        echo "Paid $amount using Credit Card\n";
    }
}

class PayPalPayment implements PaymentMethod {
    public function pay($amount) {
        echo "Paid $amount using PayPal\n";
    }
}

class PaymentService {
    private $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function process($amount) {
        $this->paymentMethod->pay($amount);
    }
}

// Example usage:
// $service = new PaymentService(new CreditCardPayment());
// $service->process(100);

// $service = new PaymentService(new PayPalPayment());
// $service->process(50);

class Container {
    private array $container = []; 

    public function register(string $interface,string $class){

        if(isset($this->container[$interface])) return;

        $this->container[$interface] = new $class();
    }

    public function getService (string $service){
        if(!isset($this->container[$service])){
          throw new Exception("service not found");     
        }
        return $this->container[$service];
    }
}

$c = new Container();
$c->register(PaymentMethod::class,CreditCardPayment::class);
$c->register(PaymentMethod::class,PayPalPayment::class);
$paymentService = new PaymentService($c->getService(PaymentMethod::class));
$paymentService->process(200);
