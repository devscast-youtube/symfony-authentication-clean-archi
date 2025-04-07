<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger;

use Classroom\SharedContext\Application\Messaging\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    use HandleTrait {
        HandleTrait::handle as messengerHandle;
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @throws \Throwable
     */
    public function handle(object $command): mixed
    {
        try {
            return $this->messengerHandle($command);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                /** @var \Throwable $e */
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
