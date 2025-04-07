<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL;

use Classroom\StudentManagement\Application\ReadModel\StudentList;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentList;
use Classroom\StudentManagement\Application\UseCase\QueryHandler\GetStudentListHandler;
use Classroom\StudentManagement\Domain\Model\Factory\AddressFactory;
use Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL\Feature\StudentQuery;
use Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\StudentCacheKeys;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;

/**
 * Class GetStudentListDbalHandler.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class GetStudentListDbalHandler implements GetStudentListHandler
{
    use StudentQuery;

    public function __construct(
        private Connection $connection,
        private AddressFactory $addressFactory
    ) {
    }

    #[\Override]
    public function __invoke(GetStudentList $query): StudentList
    {
        $qb = $this->createBaseQuery()
            ->enableResultCache(new QueryCacheProfile(0, StudentCacheKeys::LIST->value))
        ;

        /** @var array $data */
        $data = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapStudentList($data);
    }

    private function mapStudentList(array $data): StudentList
    {
        return new StudentList(array_map(fn ($item) => $this->mapStudentProfile($item), $data));
    }
}
