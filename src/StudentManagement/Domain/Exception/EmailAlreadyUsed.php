<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Exception;

use Classroom\SharedContext\Domain\Exception\UserFacingError;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

final class EmailAlreadyUsed extends \DomainException implements UserFacingError
{
    public static function with(Email $email): self
    {
        return new self(sprintf('Email %s is already used', $email));
    }

    public function translationId(): string
    {
        return 'student_management.exceptions.email_already_used';
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
