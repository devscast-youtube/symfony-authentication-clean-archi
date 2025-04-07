<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL\Feature;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Application\ReadModel\StudentProfile;
use Classroom\StudentManagement\Domain\Model\ValueObject\Age;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;
use Doctrine\DBAL\Query\QueryBuilder;

trait StudentQuery
{
    private function createBaseQuery(): QueryBuilder
    {
        return $qb = $this->connection->createQueryBuilder()
            ->from('student', 's')
            ->select('s.id, s.birthdate, s.email_value as email, s.username_value as username')
            ->addSelect('s.city as address_city, s.country as address_country, s.address_line1, s.address_line2');
    }

    private function mapStudentProfile(array $data): StudentProfile
    {
        return new StudentProfile(
            $data['id'],
            new Username($data['username']),
            new Email($data['email']),
            $this->addressFactory->create(
                $data['address_city'],
                $data['address_country'],
                $data['address_line1'],
                $data['address_line2']
            ),
            Age::fromDateTime(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['birthdate']))
        );
    }
}
