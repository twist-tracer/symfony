<?php

namespace App\MessageHandler;

use App\Message\SmsNotification;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsNotificationHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __invoke(SmsNotification $message): void
    {
        $this->logger->info(sprintf(
            'Sms "%s" has been sent',
            $message->getContent()
        ));
    }
}
