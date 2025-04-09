<?php

namespace Classroom\StudentManagement\Application\UseCase\CommandHandler;

use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\StudentManagement\Application\UseCase\Command\AddStudent;
use Classroom\StudentManagement\Domain\Model\Entity\Student;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;
use Classroom\StudentManagement\Domain\Service\AgeVerifier;
use Classroom\StudentManagement\Domain\Service\EmailVerifier;

final readonly class AddStudentHandler implements CommandHandler
{
    public function __construct(
        private AgeVerifier $ageVerifier,
        private EmailVerifier $emailVerifier,
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(AddStudent $command): void
    {
        $this->emailVerifier->assertNotUsed($command->email);
        $this->ageVerifier->assertNotUnderage($command->birthdate);

        $student = new Student(
            $command->email,
            $command->username,
            $command->address,
            $command->birthdate
        );

        $this->studentRepository->add($student);
    }
}
