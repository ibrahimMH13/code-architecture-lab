<?php

interface INotifier {
    public function send(array $data): void;
}

interface INotificationDispatcher {
    public function notify(array $data): void;
}

// --- Concrete Notifiers ---

class EmailNotifier implements INotifier {
    public function send(array $data): void {
        echo "Sending Email to {$data['user']}\n";
    }
}

class InAppNotifier implements INotifier {
    public function send(array $data): void {
        echo "Sending In-App Notification to {$data['user']}\n";
    }
}

class SMSNotifier implements INotifier {
    public function send(array $data): void {
        echo "Sending SMS to {$data['user']}\n";
    }
}

class WhatsAppNotifier implements INotifier {
    public function send(array $data): void {
        echo "Sending WhatsApp Message to {$data['user']}\n";
    }
}

// --- Dispatcher ---

class NotificationDispatcher implements INotificationDispatcher {
    public function __construct(private array $notifiers) {}

    public function notify(array $data): void {
        foreach($this->notifiers as $notifier){
            $notifier->send($data);
        }
      
    }
}

// --- Usage Example ---

$data = ['user' => 'john@example.com'];

$dispatcher = new NotificationDispatcher([new SMSNotifier(), new WhatsAppNotifier(),new EmailNotifier()]);
$dispatcher->notify($data);
