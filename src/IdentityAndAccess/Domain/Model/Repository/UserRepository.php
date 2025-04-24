<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Model\Repository;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\IdentityAndAccess\Domain\Model\Entity\User;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Interface UserRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface UserRepository
{
    public function add(User $user): void;

    public function remove(User $user): void;

    public function getById(UserId $userId): User;

    public function getByEmail(Email $email): ?User;
}
