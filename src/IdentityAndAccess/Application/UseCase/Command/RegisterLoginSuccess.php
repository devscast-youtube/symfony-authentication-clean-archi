<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\Command;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\SharedContext\Domain\Model\ValueObject\Tracking\ClientProfile;

/**
 * Class RegisterLogin.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class RegisterLoginSuccess
{
    public function __construct(
        public UserId $userId,
        public ClientProfile $profile
    ) {
    }
}
