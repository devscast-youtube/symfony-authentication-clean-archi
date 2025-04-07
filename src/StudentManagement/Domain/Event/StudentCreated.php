<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Event;

/**
 * Class StudentCreated.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class StudentCreated
{
    public function __construct(
        public int $studentId
    ) {
    }
}
