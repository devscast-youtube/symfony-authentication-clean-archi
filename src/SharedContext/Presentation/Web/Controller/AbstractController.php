<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Presentation\Web\Controller;

use Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger\MessengerCommandBus;
use Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;

/**
 * Class AbstractController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractController extends SymfonyController
{
    #[\Override]
    public static function getSubscribedServices(): array
    {
        $subscribedServices = parent::getSubscribedServices();

        $subscribedServices[] = MessengerCommandBus::class;
        $subscribedServices[] = MessengerQueryBus::class;

        return $subscribedServices;
    }

    protected function handleCommand(object $command): mixed
    {
        return $this->container->get(MessengerCommandBus::class)->handle($command);
    }

    protected function handleQuery(object $query): mixed
    {
        return $this->container->get(MessengerQueryBus::class)->handle($query);
    }
}
