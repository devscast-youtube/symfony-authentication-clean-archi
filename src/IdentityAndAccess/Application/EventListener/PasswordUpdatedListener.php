<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\PasswordUpdatedEmail;
use Classroom\IdentityAndAccess\Domain\Event\PasswordUpdated;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class PasswordUpdatedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordUpdatedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(PasswordUpdated $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new PasswordUpdatedEmail($user->email);

        $this->mailer->send($email);
    }
}
