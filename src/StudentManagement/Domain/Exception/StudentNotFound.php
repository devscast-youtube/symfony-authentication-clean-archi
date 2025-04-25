<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Exception;

use Classroom\SharedContext\Domain\Exception\UserFacingError;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;

/**
 * Class StudentNotFound.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class StudentNotFound extends \DomainException implements UserFacingError
{
    public static function withId(StudentId $studentId): self
    {
        return new self(sprintf('Student with id %s not found', $studentId->toString()));
    }

    public function translationId(): string
    {
        return 'student_management.exceptions.student_not_found';
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
