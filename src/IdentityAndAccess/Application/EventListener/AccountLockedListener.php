<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\AccountLockedEmail;
use Classroom\IdentityAndAccess\Domain\Event\AccountLocked;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class AccountLockedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountLockedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(AccountLocked $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new AccountLockedEmail($user->email, $event->token);

        $this->mailer->send($email);
    }
}
