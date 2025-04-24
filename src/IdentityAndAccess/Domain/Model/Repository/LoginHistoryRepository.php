<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Model\Repository;

use Classroom\IdentityAndAccess\Domain\Model\Entity\LoginHistory;
use Classroom\IdentityAndAccess\Domain\Model\Entity\User;

/**
 * Interface LoginHistoryRepository.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface LoginHistoryRepository
{
    public function add(LoginHistory $loginHistory): void;

    public function remove(LoginHistory $loginHistory): void;

    public function getLastBy(User $user): ?LoginHistory;
}
