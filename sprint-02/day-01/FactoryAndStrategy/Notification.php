<?php



interface Notifier {

    public function notify(array $data);
}

class SmsNotifier implements Notifier{

    public function notify(array $data){
            echo "sending sms\n";
    }
}

class EmailNotifier implements Notifier{

    public function notify(array $data){
            echo "sending email\n";
    }
}

class PushNotifier implements Notifier{

    public function notify(array $data){
            echo "sending push\n";
    }
}

interface INotificationFactory {

    public static function create(string $type):Notifier;
}


class NotificationFactory implements INotificationFactory{

    public static function create(string $type):Notifier{

        return match ($type) {
            "sms" => new SmsNotifier(),
            "email" => new EmailNotifier(),
            "push" => new PushNotifier()
        };
    }
}

class Order {
    protected array $order = [];
    public function __construct(protected Notifier $notifier){}
    public function handle(array $data){
        $this->order = $data;
        echo "processing order";
        return $this;
    }

    public function notify(){
        $this->notifier->notify($this->order);
    }

    public function setNotifier(Notifier $notifier){
        $this->notifier = $notifier;
    }

}
$n = NotificationFactory::create("sms");

$o = new Order($n);

$o->handle(["email"=>"ibrahim@test.com"])->notify();

$o->setNotifier(NotificationFactory::create("push"));
$o->notify();