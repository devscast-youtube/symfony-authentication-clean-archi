<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\PasswordCreatedEmail;
use Classroom\IdentityAndAccess\Domain\Event\PasswordCreated;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class PasswordCreatedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordCreatedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(PasswordCreated $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new PasswordCreatedEmail($user->email, $event->password);

        $this->mailer->send($email);
    }
}
