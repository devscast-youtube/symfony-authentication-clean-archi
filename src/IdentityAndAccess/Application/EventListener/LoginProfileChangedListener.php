<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\EventListener;

use Classroom\IdentityAndAccess\Application\Email\LoginProfileChangedEmail;
use Classroom\IdentityAndAccess\Domain\Event\LoginProfileChanged;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Application\Email\Mailer;
use Classroom\SharedContext\Application\EventListener\EventListener;

/**
 * Class LoginProfileChangedListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class LoginProfileChangedListener implements EventListener
{
    public function __construct(
        private Mailer $mailer,
        private UserRepository $userRepository
    ) {
    }

    public function __invoke(LoginProfileChanged $event): void
    {
        $user = $this->userRepository->getById($event->userId);
        $email = new LoginProfileChangedEmail($user->email, $event->device, $event->location);

        $this->mailer->send($email);
    }
}
