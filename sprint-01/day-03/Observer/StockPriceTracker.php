<?php
interface Subject {
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(array $data): void;
}

interface Observer {
    public function update(Subject $subject, array $data): void;
}

interface Notifier {
    public function notify(array $data): void;
}

class Stock implements Subject {
    protected array $observers = [];

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        $this->observers = array_filter(
            $this->observers,
            fn($o) => $o !== $observer
        );
    }

    public function notify(array $data): void {
        foreach ($this->observers as $observer) {
            $observer->update($this, $data);
        }
    }
}

class EmailNotifier implements Notifier {
    public function notify(array $data): void {
        echo "📧 Email: Stock {$data['symbol']} at price {$data['price']}\n";
    }
}

class DashboardWidget implements Notifier {
    public function notify(array $data): void {
        echo "📊 Dashboard: Stock {$data['symbol']} updated to {$data['price']}\n";
    }
}

class Dispatcher {
    private const DISPATCHERS = [
        DashboardWidget::class,
        EmailNotifier::class
    ];

    public function processing(array $data): void {
        foreach (self::DISPATCHERS as $notifierClass) {
            (new $notifierClass())->notify($data);
        }
    }
}

class StockObserver implements Observer {
    public function update(Subject $subject, array $data): void {
        (new Dispatcher())->processing($data);
    }
}

// 🧪 Usage
$stock = new Stock();
$stock->attach(new StockObserver());

$stock->notify(['symbol' => 'AAPL', 'price' => 199.5]);
