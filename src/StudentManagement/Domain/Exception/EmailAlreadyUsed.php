<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Exception;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;

final class EmailAlreadyUsed extends \DomainException
{
    public static function with(Email $email): self
    {
        return new self(sprintf('Email %s is already used', $email));
    }
}
