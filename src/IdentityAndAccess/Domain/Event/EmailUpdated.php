<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class EmailUpdated.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class EmailUpdated
{
    public function __construct(
        public UserId $userId,
        public Email $previous,
        public Email $current
    ) {
    }
}
