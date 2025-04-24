<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\Command;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class RequestPassword.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class RequestPassword
{
    public function __construct(
        public Email $email
    ) {
    }
}
