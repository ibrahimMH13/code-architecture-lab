<?php

interface NotifierInterface {
    public function notify(string $user): void;
}


class EmailNotifier implements NotifierInterface {
    public function notify(string $user): void {
        echo "Sending EMAIL to $user\n";
    }
}

class SmsNotifier implements NotifierInterface {
    public function notify(string $user): void {
        echo "Sending SMS to $user\n";
    }
}

class PushNotifier implements NotifierInterface {
    public function notify(string $user): void {
        echo "Sending PUSH notification to $user\n";
    }
}

class NotifierFactory {
    private const MAP = [
        'email' => EmailNotifier::class,
        'sms'   => SmsNotifier::class,
        'push'  => PushNotifier::class,
    ];

    public static function create(string $type): NotifierInterface {
        if (!isset(self::MAP[$type])) {
            throw new Exception("Notifier type [$type] not supported.");
        }

        $class = self::MAP[$type];
        return new $class();
    }
}


$user = 'john@example.com';
$type = 'sms';

$notifier = NotifierFactory::create($type);
$notifier->notify($user);
