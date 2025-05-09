<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Infrastructure\Persistence\Doctrine\DBAL\Types;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

/**
 * Class UserIdType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UserIdType extends AbstractUidType
{
    #[\Override]
    public function getName(): string
    {
        return 'user_id';
    }

    #[\Override]
    protected function getUidClass(): string
    {
        return UserId::class;
    }
}
