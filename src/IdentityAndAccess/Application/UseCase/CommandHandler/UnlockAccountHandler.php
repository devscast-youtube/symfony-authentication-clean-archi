<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\UnlockAccount;
use Classroom\IdentityAndAccess\Domain\Model\Repository\LoginAttemptRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\VerificationTokenRepository;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\TokenPurpose;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;

/**
 * Class ResetPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class UnlockAccountHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private VerificationTokenRepository $verificationTokenRepository,
        private LoginAttemptRepository $loginAttemptRepository,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function __invoke(UnlockAccount $command): void
    {
        $token = $this->verificationTokenRepository->getByToken(
            $command->token,
            TokenPurpose::UNLOCK_ACCOUNT
        );

        $user = $this->userRepository->getById($token->user->id);
        $user->unlockAccount();

        $this->userRepository->add($user);
        $this->verificationTokenRepository->remove($token);
        $this->loginAttemptRepository->deleteBy($user);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }
}
