<?php

namespace Classroom\StudentManagement\Application\UseCase\CommandHandler;

use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\StudentManagement\Application\UseCase\Command\DeleteStudent;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;

final readonly class DeleteStudentHandler implements CommandHandler
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(DeleteStudent $command): void
    {
        $student = $this->studentRepository->getById($command->studentId);
        $this->studentRepository->remove($student);
    }
}
