<?php

namespace App\Event\Listener;

use Symfony\Component\Console\Event\ConsoleTerminateEvent;

class MyCustomListener
{
    public function __invoke(ConsoleTerminateEvent $event): void
    {
        dump('Console command finished');
    }

}