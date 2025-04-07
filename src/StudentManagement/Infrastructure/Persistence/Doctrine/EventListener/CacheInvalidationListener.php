<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\EventListener;

use Classroom\StudentManagement\Domain\Model\Entity\Student;
use Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\StudentCacheKeys;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class CacheInvalidationListener.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsDoctrineListener(Events::postRemove)]
#[AsDoctrineListener(Events::postUpdate)]
#[AsDoctrineListener(Events::postPersist)]
final readonly class CacheInvalidationListener
{
    private ?CacheItemPoolInterface $resultCache;

    public function __construct(
        private Connection $connection,
    ) {
        $this->resultCache = $this->connection->getConfiguration()->getResultCache();
    }

    /**
     * @param LifecycleEventArgs<EntityManagerInterface> $event
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __invoke(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof Student && $entity->id !== null) {
            $this->resultCache?->deleteItems([
                StudentCacheKeys::PROFILE->withId($entity->id),
                StudentCacheKeys::LIST->value,
            ]);
        }
    }
}
