<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\RequestPassword;
use Classroom\IdentityAndAccess\Domain\Exception\UserNotFound;
use Classroom\IdentityAndAccess\Domain\Model\Entity\User;
use Classroom\IdentityAndAccess\Domain\Model\Entity\VerificationToken;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\VerificationTokenRepository;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\TokenPurpose;
use Classroom\IdentityAndAccess\Domain\Service\SecretGenerator;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;

/**
 * Class RequestPasswordHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class RequestPasswordHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private VerificationTokenRepository $verificationTokenRepository,
        private SecretGenerator $secretGenerator,
        private EventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(RequestPassword $command): void
    {
        $user = $this->userRepository->getByEmail($command->email);
        if ($user === null) {
            throw UserNotFound::withEmail($command->email);
        }

        $token = $this->createVerificationToken($user);
        $user->requestPasswordReset($token);

        $this->userRepository->add($user);
        $this->verificationTokenRepository->add($token);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }

    private function createVerificationToken(User $user): VerificationToken
    {
        $secret = $this->secretGenerator->generateToken();
        return VerificationToken::create($user, $secret, TokenPurpose::PASSWORD_RESET);
    }
}
