<?php

namespace App\Event\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

class MyCustomListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(ConsoleTerminateEvent $event): void
    {
        $this->logger->debug('Console command finished');
    }
}
