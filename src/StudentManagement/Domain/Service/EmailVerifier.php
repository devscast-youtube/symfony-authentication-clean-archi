<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Service;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Exception\EmailAlreadyUsed;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;

/**
 * Class EmailVerifier.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class EmailVerifier
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function assertNotUsed(Email $email): void
    {
        $used = $this->studentRepository->getByEmail($email);

        if ($used !== null) {
            throw EmailAlreadyUsed::with($email);
        }
    }
}
