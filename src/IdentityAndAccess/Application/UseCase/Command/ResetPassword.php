<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\Command;

use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;

/**
 * Class ResetPassword.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ResetPassword
{
    public function __construct(
        public GeneratedToken $token,
        public string $password
    ) {
    }
}
