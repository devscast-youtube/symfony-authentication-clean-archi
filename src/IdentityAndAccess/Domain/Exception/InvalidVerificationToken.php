<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Exception;

use Classroom\SharedContext\Domain\Exception\UserFacingError;

/**
 * Class InvalidToken.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class InvalidVerificationToken extends \DomainException implements UserFacingError
{
    #[\Override]
    public function translationId(): string
    {
        return 'identity_and_access.exceptions.invalid_verification_token';
    }

    #[\Override]
    public function translationParameters(): array
    {
        return [];
    }

    #[\Override]
    public function translationDomain(): string
    {
        return 'identity_and_access';
    }
}
