<?php

// --- Interfaces ---

interface IBookingService {
    public function newBooking(): self;
    public function notify(INotifier $notifier): void;
}

interface IRepository {
    public function save(array $data): Booking;
}

interface IValidator {
    public function validate(array $data): void;
}

interface INotifier {
    public function notify(array $data): void;
}

// --- Domain Object ---

class Booking {
    public function __construct(public string $user, public string $date) {}
}

// --- SRP Classes ---

class BookingValidator implements IValidator {
    public function validate(array $data): void {
        if (empty($data['user']) || empty($data['date'])) {
            throw new Exception("Invalid booking data");
        }
    }
}

class BookingRepository implements IRepository {
    public function save(array $data): Booking {
        echo "✅ Booking saved for user: {$data['user']} on {$data['date']}\n";
        return new Booking($data['user'], $data['date']);
    }
}

class EmailNotifier implements INotifier {
    public function notify(array $data): void {
        echo "📧 Email sent to {$data['user']}\n";
    }
}

class BookingService implements IBookingService {
    public function __construct(
        private array $data,
        private IValidator $validator,
        private IRepository $repository
    ) {}

    public function newBooking(): self {
        $this->validator->validate($this->data);
        $this->repository->save($this->data);
        return $this;
    }

    public function notify(INotifier $notifier): void {
        $notifier->notify($this->data);
    }
}

$data = [
    'user' => 'john@example.com',
    'date' => '2025-06-16',
];

$service = new BookingService($data, new BookingValidator(), new BookingRepository());
$service->newBooking()->notify(new EmailNotifier());
