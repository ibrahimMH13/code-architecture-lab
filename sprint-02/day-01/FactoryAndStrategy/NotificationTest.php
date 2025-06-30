<?php
use PHPUnit\Framework\TestCase;

require_once './Notification.php';


class NotificationTest extends TestCase{ 

    public function testNotifyCallsNotifier(){

        $notifierMocked =  $this->createMock(Notifier::class);
        $notifierMocked->expects($this->once())->method("notify")->with(["email"=>"ibrahim@test.com"]);
       
        $o = new Order($notifierMocked);
        $o->handle(["email"=>"ibrahim@test.com"])->notify();
    }

    public function testFactoryReturnsEmailNotifier()
{
    $notifier = NotificationFactory::create('email');
    $this->assertInstanceOf(EmailNotifier::class, $notifier);
}

public function testFactoryReturnsSmsNotifier()
{
    $notifier = NotificationFactory::create('sms');
    $this->assertInstanceOf(SmsNotifier::class, $notifier);
}

}