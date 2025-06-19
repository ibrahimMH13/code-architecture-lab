<?php

interface Logger {
    public function log(string $level, string $message): void;
}

class FileLogger implements Logger {
    public function log(string $level, string $message): void {
    }
}
class ExternalLoggerService {
    public function writeLog($msg, $priority) {
    }
}

class SlackLoggerAdapter implements Logger {
    protected ExternalLoggerService $externalLoggerService;

    public function __construct(ExternalLoggerService $externalLoggerService) {
        $this->externalLoggerService = $externalLoggerService;
    }

    public function log(string $level, string $message): void {
        $this->externalLoggerService->writeLog($message, $level);
    }
}
$externalLogger = new ExternalLoggerService();
$logger = new SlackLoggerAdapter($externalLogger);

$logger->log('info', 'Hello, Slack!');
