<?php


interface Payment {} 

interface CreditCardPayment extends Payment {
    public function payWithCreditCard($cardNumber, $expiry, $cvv, $amount);
}

interface PaypalPayment extends Payment {
    public function payWithPaypal($paypalEmail, $amount);
}

interface CryptoPayment extends Payment {
    public function payWithCrypto($walletAddress, $amount);
}

interface BankTransferPayment extends Payment {
    public function payWithBankTransfer($iban, $amount);
}
