<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Infrastructure\Persistence\Doctrine\DBAL\Types;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\LoginAttemptId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

/**
 * Class LoginAttemptId.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class LoginAttemptIdType extends AbstractUidType
{
    #[\Override]
    public function getName(): string
    {
        return 'login_attempt_id';
    }

    #[\Override]
    protected function getUidClass(): string
    {
        return LoginAttemptId::class;
    }
}
