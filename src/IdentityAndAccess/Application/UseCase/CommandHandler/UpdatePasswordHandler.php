<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\UpdatePassword;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\IdentityAndAccess\Domain\Service\PasswordHasher;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;

/**
 * Class UpdatePasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class UpdatePasswordHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function __invoke(UpdatePassword $command): void
    {
        $user = $this->userRepository->getById($command->userId);
        $user->updatePassword($command->current, $command->password, $this->passwordHasher);

        $this->userRepository->add($user);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }
}
