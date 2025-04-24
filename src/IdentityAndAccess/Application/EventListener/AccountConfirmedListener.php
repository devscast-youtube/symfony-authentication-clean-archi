<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\AccountConfirmedEmail;
use Classroom\IdentityAndAccess\Domain\Event\AccountConfirmed;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class AccountConfirmedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountConfirmedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(AccountConfirmed $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new AccountConfirmedEmail($user->email, false, null);

        $this->mailer->send($email);
    }
}
