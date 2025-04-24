<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Application\UseCase\Query;

use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;

/**
 * Class GetStudentProfile.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class GetStudentProfile
{
    public function __construct(
        public StudentId $studentId
    ) {
    }
}
