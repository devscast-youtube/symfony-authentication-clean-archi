<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\LockAccount;
use Classroom\IdentityAndAccess\Application\UseCase\Command\RegisterLoginAttempt;
use Classroom\IdentityAndAccess\Domain\Model\Entity\LoginAttempt;
use Classroom\IdentityAndAccess\Domain\Model\Repository\LoginAttemptRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Messaging\CommandBus;
use Classroom\SharedContext\Application\Messaging\CommandHandler;

/**
 * Class RegisterLoginAttemptHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class RegisterLoginAttemptHandler implements CommandHandler
{
    private const int ATTEMPTS_LIMIT = 3;

    public function __construct(
        private UserRepository $userRepository,
        private LoginAttemptRepository $loginAttemptRepository,
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(RegisterLoginAttempt $command): void
    {
        $user = $this->userRepository->getById($command->userId);
        $attempts = $this->loginAttemptRepository->countBy($user);

        if ($attempts < self::ATTEMPTS_LIMIT) {
            $this->loginAttemptRepository->add(LoginAttempt::create($user));
        } else {
            if ($user->isLocked === false) {
                $this->commandBus->handle(new LockAccount($user->id));
            }
        }
    }
}
