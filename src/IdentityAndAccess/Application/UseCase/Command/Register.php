<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\UseCase\Command;

use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Roles;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class Register.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class Register
{
    public function __construct(
        public string $name,
        public Email $email,
        public ?string $password,
        public Roles $roles = new Roles()
    ) {
    }
}
