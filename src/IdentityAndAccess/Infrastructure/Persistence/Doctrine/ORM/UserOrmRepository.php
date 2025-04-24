<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Infrastructure\Persistence\Doctrine\ORM;

use Classroom\IdentityAndAccess\Domain\Exception\UserNotFound;
use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\IdentityAndAccess\Domain\Model\Entity\User;
use Classroom\IdentityAndAccess\Domain\Model\Repository\UserRepository;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserOrmRepository.
 *
 * @extends ServiceEntityRepository<User>
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserOrmRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    #[\Override]
    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function getById(UserId $userId): User
    {
        $user = $this->findOneBy([
            'id' => $userId,
        ]);

        if ($user === null) {
            throw UserNotFound::withId($userId);
        }

        return $user;
    }

    #[\Override]
    public function getByEmail(Email $email): ?User
    {
        return $this->findOneBy([
            'email' => $email->value,
        ]);
    }
}
