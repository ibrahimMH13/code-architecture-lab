<?php

interface Account {
    public function deposit(float $amount): void;
    public function getBalance(): float;
}
 
interface withdrawable extends Account{
    public function withdraw(float $amount): void;
}

class StandardAccount implements withdrawable {
    protected float $balance = 0;

    public function __construct() {}

    public function deposit(float $amount): void {
        $this->balance += $amount;
        echo "Depositing $amount into Standard Account\n";
    }

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            throw new Exception("Insufficient funds");
        }
        $this->balance -= $amount;
        echo "Withdrawing $amount from Standard Account\n";
    }

    public function getBalance(): float {
        return $this->balance;
    }
}

class FixedDepositAccount implements Account {
    protected float $fixedDeposit = 0;

    public function __construct() {}

    public function deposit(float $amount): void {
        $this->fixedDeposit += $amount;
        echo "Depositing $amount into Fixed Deposit Account\n";
    }
    public function getBalance(): float {
        return $this->fixedDeposit;
    }
}

class BankManagement {
    public function processWithdrawal(Account $account, float $amount): void {
        try {
            $account->withdraw($amount);
        } catch (Exception $e) {
            echo "⚠️ " . $e->getMessage() . "\n";
        }
    }
}

$bank = new BankManagement();

$accountTypes = [
    StandardAccount::class,
    FixedDepositAccount::class
];

foreach ($accountTypes as $account) {
    try {
        $bank->processWithdrawal(new $account(), 34.2);
    } catch (Throwable $e) {
        echo "something went wrong , try again later \n";
    }
}

echo "-----------------------------------------------";



interface Machine{}
interface Printer extends Machine{
    public function printDocument();
}
interface Scanner extends Machine{
    public function scanDocument();
}
interface Fax extends Machine{
    public function faxDocument();
}


class OldPrinter implements Printer{

    public function printDocument(){
        echo "\ndoing print now\n";
    }
}


class DeviceManager {

    public function print(Printer $device){
            echo $device->printDocument();
    }
}

$dm = new DeviceManager();

$dm->print(new OldPrinter());