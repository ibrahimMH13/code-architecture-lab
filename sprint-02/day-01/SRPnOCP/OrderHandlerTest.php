<?php

use PHPUnit\Framework\TestCase;

require_once './OrderHandler.php';


class OrderHandlerTest extends TestCase{ 

    public function testNotifyCallsNotifier(){
        
        $notifierMock = $this->createMock(EmailNotifier::class);

        $notifierMock->expects($this->once())->method("notify")->with([
            "email" =>"ibrahim@exmaple.com"
        ]);

        $orderManager = new OrderManager($notifierMock);
        $orderManager->handleOrder(['email' => 'ibrahim@exmaple.com'])->notify();
        
    }
}