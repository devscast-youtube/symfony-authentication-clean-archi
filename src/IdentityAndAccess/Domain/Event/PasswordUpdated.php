<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;

/**
 * Class PasswordUpdated.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordUpdated
{
    public function __construct(
        public UserId $userId
    ) {
    }
}
