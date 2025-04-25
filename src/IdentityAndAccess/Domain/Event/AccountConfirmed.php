<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;

/**
 * Class UserConfirmed.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountConfirmed
{
    public function __construct(
        public UserId $userId
    ) {
    }
}
