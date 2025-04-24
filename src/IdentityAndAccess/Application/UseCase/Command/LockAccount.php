<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\Command;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;

/**
 * Class LockAccount.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class LockAccount
{
    public function __construct(
        public UserId $userId
    ) {
    }
}
