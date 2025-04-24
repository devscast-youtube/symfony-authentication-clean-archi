<?php

namespace Classroom\StudentManagement\Domain\Model\Entity;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;

class Student
{
    private(set) StudentId $id;

    public function __construct(
        private(set) Email $email,
        private(set) Username $username,
        private(set) Address $address,
        private(set) \DateTimeImmutable $birthdate,
    ) {
        $this->id = new StudentId();
    }

    public function updateProfile(
        Email $email,
        Username $username,
        Address $address,
        \DateTimeImmutable $birthdate
    ): void {
        $this->email = $email;
        $this->username = $username;
        $this->address = $address;
        $this->birthdate = $birthdate;
    }
}
