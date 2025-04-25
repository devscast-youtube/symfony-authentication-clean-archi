<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\ConfirmAccount;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\VerificationTokenRepository;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\TokenPurpose;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;

/**
 * Class ConfirmRegistrationHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ConfirmAccountHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private VerificationTokenRepository $verificationTokenRepository,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function __invoke(ConfirmAccount $command): void
    {
        $token = $this->verificationTokenRepository->getByToken(
            $command->token,
            TokenPurpose::CONFIRM_ACCOUNT
        );

        $user = $this->userRepository->getById($token->user->id);
        $user->confirmAccount();

        $this->verificationTokenRepository->remove($token);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }
}
