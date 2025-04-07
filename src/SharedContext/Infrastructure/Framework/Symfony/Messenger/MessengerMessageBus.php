<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger;

use Classroom\SharedContext\Application\Messaging\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerMessageBus implements MessageBus
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function dispatch(object $message): void
    {
        $this->messageBus->dispatch($message);
    }
}
