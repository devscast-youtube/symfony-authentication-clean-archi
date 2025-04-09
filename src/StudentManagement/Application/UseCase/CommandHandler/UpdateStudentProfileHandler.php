<?php

namespace Classroom\StudentManagement\Application\UseCase\CommandHandler;

use Classroom\SharedContext\Application\Messaging\CommandHandler;
use Classroom\StudentManagement\Application\UseCase\Command\UpdateStudentProfile;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;
use Classroom\StudentManagement\Domain\Service\AgeVerifier;
use Classroom\StudentManagement\Domain\Service\EmailVerifier;

final readonly class UpdateStudentProfileHandler implements CommandHandler
{
    public function __construct(
        private AgeVerifier $ageVerifier,
        private EmailVerifier $emailVerifier,
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(UpdateStudentProfile $command): void
    {
        $student = $this->studentRepository->getById($command->studentId);

        if ($student->email->equals($command->email) === false) {
            $this->emailVerifier->assertNotUsed($command->email);
        }

        if ($student->birthdate != $command->birthdate) {
            $this->ageVerifier->assertNotUnderage($command->birthdate);
        }

        $student->updateProfile(
            $command->email,
            $command->username,
            $command->address,
            $command->birthdate
        );

        $this->studentRepository->add($student);
    }
}
