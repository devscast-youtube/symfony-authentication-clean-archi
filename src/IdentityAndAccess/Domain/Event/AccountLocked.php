<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;

/**
 * Class AccountLocked.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountLocked
{
    public function __construct(
        public UserId $userId,
        public GeneratedToken $token
    ) {
    }
}
