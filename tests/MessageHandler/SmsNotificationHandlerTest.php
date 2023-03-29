<?php

namespace App\Tests\MessageHandler;

use App\Message\SmsNotification;
use App\Tests\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\InMemoryTransport;
use Symfony\Component\Messenger\Transport\TransportInterface;

class SmsNotificationHandlerTest extends TestCase
{
    private MessageBusInterface $messenger;

    private TransportInterface $transport;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();
        $this->messenger = $container->get(MessageBusInterface::class);
        $this->transport = $container->get('messenger.transport.async');
    }

    public function testHandleSmsNotification(): void
    {
        /** @var InMemoryTransport $transport */
        $transport = $this->transport;

        $this->messenger->dispatch(new SmsNotification('Hello'));
        $this->messenger->dispatch(new SmsNotification('World!'));

        $this->assertCount(2, $transport->getSent());
    }
}
