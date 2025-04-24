<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\PasswordForgottenEmail;
use Classroom\IdentityAndAccess\Domain\Event\PasswordForgotten;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class PasswordForgottenListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordForgottenListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(PasswordForgotten $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new PasswordForgottenEmail($user->email, $event->token);

        $this->mailer->send($email);
    }
}
