<?php

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\ORM;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Exception\StudentNotFound;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Classroom\StudentManagement\Domain\Model\Entity\Student;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentOrmRepository extends ServiceEntityRepository implements StudentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function add(Student $student): void
    {
        $this->getEntityManager()->persist($student);
        $this->getEntityManager()->flush();
    }

    public function remove(Student $student): void
    {
        $this->getEntityManager()->remove($student);
        $this->getEntityManager()->flush();
    }

    public function getById(StudentId $studentId): Student
    {
        $student = $this->findOneBy([
            'id' => $studentId
        ]);

        if ($student === null) {
            throw StudentNotFound::withId($studentId);
        }

        return $student;
    }

    public function getByEmail(Email $email): ?Student
    {
        return $this->findOneBy([
            'email' => $email->value,
        ]);
    }
}
