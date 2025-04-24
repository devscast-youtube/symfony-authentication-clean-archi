<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedCode;

/**
 * Class PasswordCreated.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordCreated
{
    public function __construct(
        public UserId $userId,
        #[\SensitiveParameter] public GeneratedCode $password
    ) {
    }
}
