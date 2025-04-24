<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\PasswordResetEmail;
use Classroom\IdentityAndAccess\Domain\Event\PasswordReset;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class PasswordForgottenListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordResetListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(PasswordReset $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new PasswordResetEmail($user->email);

        $this->mailer->send($email);
    }
}
