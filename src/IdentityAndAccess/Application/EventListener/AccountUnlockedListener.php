<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\AccountUnlockedEmail;
use Classroom\IdentityAndAccess\Domain\Event\AccountUnlocked;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class AccountUnlockedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountUnlockedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(AccountUnlocked $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new AccountUnlockedEmail($user->email);

        $this->mailer->send($email);
    }
}
