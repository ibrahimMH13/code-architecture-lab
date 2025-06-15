<?php

interface IBookingService {
    public function newBooking();
    public function notify(INotifier $notifier);
}

interface IRepository {
    public function save(array $data): Booking;
}

interface BookingRepositoryInterface extends IRepository {}

interface IValidator {
    public function validate(array $data): void;
}

interface INotifier {
    public function notify(mixed $data): void;
}

interface IFactory {
    public static function create(string $type): INotifier;
}

class BookingValidator implements IValidator {
    public function validate(array $data): void {
        if (empty($data['user']) || empty($data['date'])) {
            throw new Exception("Invalid booking data");
        }
    }
}

class BookingRepository implements BookingRepositoryInterface {
    public function save(array $data): Booking {
        echo "Booking saved for user: {$data['user']} on date: {$data['date']}\n";
        return new Booking($data['user'], $data['date']);
    }
}

class BookingService implements IBookingService {
    public function __construct(
        private array $data,
        private IValidator $validator,
        private IRepository $repository
    ) {}

    private function bookingValidator(): self {
        $this->validator->validate($this->data);
        return $this;
    }

    private function store(): self {
        $this->repository->save($this->data);
        return $this;
    }

    public function newBooking(): self {
        return $this->bookingValidator()->store();
    }

    public function notify(INotifier $notifier): void {
        $notifier->notify($this->data);
    }
}

class SmsNotifier implements INotifier {
    public function notify(mixed $data): void {
        echo "Sending SMS to {$data['user']}\n";
    }
}

class PushNotifier implements INotifier {
    public function notify(mixed $data): void {
        echo "Sending Push Notification to {$data['user']}\n";
    }
}

class EmailNotifier implements INotifier {
    public function notify(mixed $data): void {
        echo "Sending Email to {$data['user']}\n";
    }
}

class NotifierFactory implements IFactory {
    const MAP = [
        'sms' => SmsNotifier::class,
        'push' => PushNotifier::class,
        'email' => EmailNotifier::class
    ];

    public static function create(string $type): INotifier {
        if (!isset(self::MAP[$type])) {
            throw new Exception("Notification type not supported: $type");
        }
        $class = self::MAP[$type];
        return new $class();
    }
}

class Booking {
    public function __construct(public string $user, public string $date) {}
}

// Example usage
$data = ['user' => 'john@example.com', 'date' => '2025-06-16', 'channel' => 'email'];
$service = new BookingService($data, new BookingValidator(), new BookingRepository());
$service->newBooking()->notify(NotifierFactory::create($data['channel']));
