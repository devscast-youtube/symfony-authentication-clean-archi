<?php

namespace Classroom\StudentManagement\Application\UseCase\Command;

use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;

final readonly class DeleteStudent
{
    public function __construct(
        public StudentId $studentId
    ) {
    }
}
