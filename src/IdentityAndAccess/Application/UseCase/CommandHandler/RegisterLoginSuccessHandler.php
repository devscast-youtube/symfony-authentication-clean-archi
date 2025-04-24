<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\CommandHandler;

use Classroom\IdentityAndAccess\Application\UseCase\Command\RegisterLoginSuccess;
use Classroom\IdentityAndAccess\Domain\Model\Entity\LoginHistory;
use Classroom\IdentityAndAccess\Domain\Model\Repository\LoginAttemptRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\LoginHistoryRepository;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\SharedContext\Domain\EventDispatcher\EventDispatcher;
use Classroom\SharedContext\Domain\Tracking\ClientProfiler;

/**
 * Class RegisterLoginSuccessHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class RegisterLoginSuccessHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private LoginHistoryRepository $loginHistoryRepository,
        private LoginAttemptRepository $loginAttemptRepository,
        private ClientProfiler $clientProfiler,
        private EventDispatcher $eventDispatcher
    ) {
    }

    public function __invoke(RegisterLoginSuccess $command): void
    {
        $user = $this->userRepository->getById($command->userId);
        $device = $this->clientProfiler->detect($command->profile);
        $location = $this->clientProfiler->locate($command->profile);

        $current = LoginHistory::create($user, $command->profile->userIp, $device, $location);
        $previous = $this->loginHistoryRepository->getLastBy($user);
        if ($previous !== null) {
            $current->matchPreviousProfile($previous);
        }

        $this->loginHistoryRepository->add($current);
        $this->loginAttemptRepository->deleteBy($user);
        $this->eventDispatcher->dispatch($current->releaseEvents());
    }
}
