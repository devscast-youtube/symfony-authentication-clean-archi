<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Exception;

use Classroom\SharedContext\Domain\Exception\UserFacingError;
use Classroom\StudentManagement\Domain\Model\ValueObject\Age;

/**
 * Class CannotRegisterUnderage.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CannotRegisterUnderage extends \DomainException implements UserFacingError
{
    public static function with(Age $age): self
    {
        return new self(sprintf('Cannot register underage student, age %d is not allowed', $age->value));
    }

    public function translationId(): string
    {
        return 'student_management.exceptions.cannot_register_underage';
    }

    public function translationParameters(): array
    {
        return [];
    }

    public function translationDomain(): string
    {
        return 'student_management';
    }
}
