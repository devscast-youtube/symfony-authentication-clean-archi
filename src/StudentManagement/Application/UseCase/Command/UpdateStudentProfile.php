<?php

namespace Classroom\StudentManagement\Application\UseCase\Command;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;

final readonly class UpdateStudentProfile
{
    public function __construct(
        public StudentId $studentId,
        public Email $email,
        public Username $username,
        public Address $address,
        public \DateTimeImmutable $birthdate
    ) {
    }
}
