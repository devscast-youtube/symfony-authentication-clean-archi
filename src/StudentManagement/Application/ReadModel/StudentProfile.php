<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Application\ReadModel;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Age;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;

/**
 * Class StudentProfile.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class StudentProfile
{
    public function __construct(
        public StudentId $id,
        public Username $username,
        public Email $email,
        public Address $address,
        public Age $age
    ) {
    }
}
