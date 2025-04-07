<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Exception;

use Classroom\StudentManagement\Domain\Model\ValueObject\Age;

/**
 * Class CannotRegisterUnderage.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CannotRegisterUnderage extends \DomainException
{
    public static function with(Age $age): self
    {
        return new self(sprintf('Cannot register underage student, age %d is not allowed', $age->value));
    }
}
