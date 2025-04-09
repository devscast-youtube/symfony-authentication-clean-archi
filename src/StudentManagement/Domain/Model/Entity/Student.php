<?php

namespace Classroom\StudentManagement\Domain\Model\Entity;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;

class Student
{
    private(set) ?int $id = null;

    public function __construct(
        private(set) Email $email,
        private(set) Username $username,
        private(set) Address $address,
        private(set) \DateTimeImmutable $birthdate,
    ) {
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
