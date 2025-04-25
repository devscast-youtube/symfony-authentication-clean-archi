<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;

/**
 * Class PasswordReset.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordReset
{
    public function __construct(
        public UserId $userId
    ) {
    }
}
