<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\ConfirmationRequestedEmail;
use Classroom\IdentityAndAccess\Domain\Event\ConfirmationRequested;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class UserRegisteredListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ConfirmationRequestedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(ConfirmationRequested $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new ConfirmationRequestedEmail($user->email, $user->name, $event->token);

        $this->mailer->send($email);
    }
}
