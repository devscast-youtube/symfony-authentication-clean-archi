<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\ResetPassword;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\VerificationTokenRepository;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\TokenPurpose;
use Classroom\IdentityAndAccess\Domain\Service\PasswordHasher;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;

/**
 * Class ResetPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ResetPasswordHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private VerificationTokenRepository $verificationTokenRepository,
        private PasswordHasher $passwordHasher,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function __invoke(ResetPassword $command): void
    {
        $token = $this->verificationTokenRepository->getByToken(
            $command->token,
            TokenPurpose::PASSWORD_RESET
        );

        $user = $this->userRepository->getById($token->user->id);
        $user->resetPassword($command->password, $this->passwordHasher);

        $this->userRepository->add($user);
        $this->verificationTokenRepository->remove($token);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }
}
