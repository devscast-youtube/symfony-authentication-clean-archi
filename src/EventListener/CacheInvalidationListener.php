<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Student;
use App\StudentCacheKeys;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Connection;
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

    public function __invoke(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof Student) {
            $this->resultCache?->deleteItems([
                StudentCacheKeys::PROFILE->withId($entity->id),
                StudentCacheKeys::LIST->value
            ]);
        }
    }
}
