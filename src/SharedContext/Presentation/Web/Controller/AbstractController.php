<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Presentation\Web\Controller;

use Classroom\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger\MessengerCommandBus;
use Classroom\SharedContext\Infrastructure\Framework\Symfony\Messenger\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        $subscribedServices[] = SerializerInterface::class;
        $subscribedServices[] = TranslatorInterface::class;

        return $subscribedServices;
    }

    public function getSecurityUser(): SecurityUser
    {
        /** @var SecurityUser|null $user */
        $user = $this->getUser();

        if ($user === null) {
            throw $this->createAccessDeniedException(
                'You must be authenticated to access this resource.'
            );
        }

        return $user;
    }

    public function serialize(mixed $data, string $format = 'json', array $context = []): string
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get(SerializerInterface::class);
        return $serializer->serialize($data, $format, $context);
    }

    protected function trans(string $key, array $params = [], string $domain = 'messages'): string
    {
        /** @var TranslatorInterface $trans */
        $trans = $this->container->get(TranslatorInterface::class);
        return $trans->trans($key, $params, $domain);
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
