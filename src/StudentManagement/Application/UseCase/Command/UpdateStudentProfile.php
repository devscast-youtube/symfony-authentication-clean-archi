<?php

namespace Classroom\StudentManagement\Application\UseCase\Command;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;

final readonly class UpdateStudentProfile
{
    public function __construct(
        public int $studentId,
        public Email $email,
        public Username $username,
        public Address $address,
        public \DateTimeImmutable $birthdate
    ) {
    }
}
