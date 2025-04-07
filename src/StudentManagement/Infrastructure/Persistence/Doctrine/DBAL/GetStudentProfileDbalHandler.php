<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL;

use Classroom\StudentManagement\Application\ReadModel\StudentProfile;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentProfile;
use Classroom\StudentManagement\Application\UseCase\QueryHandler\GetStudentProfileHandler;
use Classroom\StudentManagement\Domain\Exception\StudentNotFound;
use Classroom\StudentManagement\Domain\Model\Factory\AddressFactory;
use Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL\Feature\StudentQuery;
use Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\StudentCacheKeys;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;

/**
 * Class GetStudentProfileDbalHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class GetStudentProfileDbalHandler implements GetStudentProfileHandler
{
    use StudentQuery;

    public function __construct(
        private Connection $connection,
        private AddressFactory $addressFactory
    ) {
    }

    #[\Override]
    public function __invoke(GetStudentProfile $query): StudentProfile
    {
        $qb = $this->createBaseQuery()
            ->andWhere('s.id = :id')
            ->setParameter('id', $query->studentId)
            ->enableResultCache(new QueryCacheProfile(0, StudentCacheKeys::PROFILE->withId($query->studentId)))
        ;

        /** @var false|array $data */
        $data = $qb->executeQuery()->fetchAssociative();

        if ($data === false) {
            throw StudentNotFound::withId($query->studentId);
        }

        return $this->mapStudentProfile($data);
    }
}
