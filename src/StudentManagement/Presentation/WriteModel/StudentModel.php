<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Presentation\WriteModel;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Student;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StudentModel.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class StudentModel
{
    public function __construct(
        public ?Email $email = null,
        public ?Username $username = null,
        public Address $address = new Address(),
        #[Assert\LessThan('today')] public ?\DateTimeImmutable $birthdate = null
    ) {
    }

    public static function createFromEntity(Student $student): self
    {
        return new self(
            $student->email,
            $student->username,
            $student->address,
            $student->birthdate
        );
    }
}
