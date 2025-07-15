<?php


interface InvoiceBuilderInterface{
    public function setCustomerName(string $name):self;
    public function setItem(string $name, float $price, int $qty = 1): self;
    public function setDiscount(float $amount):self;
    public function setRateTax(float $amount):self;
    public function build():Invoice;
}


class Invoice{
    public string $customerName;
    public array $items = [];
    public float $discount = 0;
    public float $taxRate = 0.0;
    public float $total = 0;


    public function calculate():void{
        $subTotal = 0;
        foreach($this->items as $item){
            $subTotal = $item['price'] * $item['qty'];
        }
        $subTotal -= $this->discount;
        $this->total = $subTotal + ($subTotal * $this->taxRate);
    }


    public function print():void{
        echo "\nInvoice for {$this->customerName}\n\n";
        foreach($this->items as $item){
            echo "      - {$item['name']}  @ \${$item['price']} x {$item['qty']}\n";
        }
        $format = $this->taxRate * 100;
        echo "\nDiscount: \${$this->discount}\n";
        echo "Tax Rate: {$format}%\n";
        echo "Total: \${$this->total}\n";
    }
}

class InvoiceBuilder implements InvoiceBuilderInterface{
    protected Invoice $invoice;

    public function __construct(){
        $this->invoice = new Invoice;
    }

    public function setCustomerName(string $name):self{
        $this->invoice->customerName = $name;
        return $this;
    }

    public function setItem(string $name, float $price, int $qty = 1) :self {
        $this->invoice->items[] = [
            'name' => $name,
            'price' => $price,
            'qty' => $qty
        ];
        return $this;
    }

    public function setDiscount(float $discount):self{
        $this->invoice->discount= $discount;
        return $this;
    }

    public function setRateTax(float $rate):self{

        $this->invoice->taxRate = $rate;
        return $this;
    }

    public function build():Invoice{
        $this->invoice->calculate();
      return  $this->invoice;
    }
}


$invoiceBuilder = new  InvoiceBuilder;

$invoiceService = $invoiceBuilder->setCustomerName('Ibrahim MH')
                                 ->setItem('bread',9.99,3)
                                 ->setItem('tomato',4.99,2)
                                 ->setDiscount(0.20)
                                 ->setRateTax(0.1)
                                 ->build();

$invoiceService->print();