<?php

namespace Classroom\StudentManagement\Application\UseCase\Command;

final readonly class DeleteStudent
{
    public function __construct(
        public int $studentId
    ) {
    }
}
