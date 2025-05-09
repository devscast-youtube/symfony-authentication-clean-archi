<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\Email;

use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;
use Classroom\SharedContext\Application\Email\EmailDefinition;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class AccountBlockedEmail.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AccountLockedEmail implements EmailDefinition
{
    public function __construct(
        private Email $recipient,
        private GeneratedToken $token
    ) {
    }

    #[\Override]
    public function recipient(): Email
    {
        return $this->recipient;
    }

    #[\Override]
    public function subject(): string
    {
        return 'identity_and_access.emails.subjects.account_locked';
    }

    #[\Override]
    public function subjectVariables(): array
    {
        return [];
    }

    #[\Override]
    public function template(): string
    {
        return 'identity_and_access/account_locked';
    }

    #[\Override]
    public function templateVariables(): array
    {
        return [
            'token' => $this->token,
        ];
    }

    #[\Override]
    public function locale(): string
    {
        return 'fr';
    }

    #[\Override]
    public function getDomain(): string
    {
        return 'identity_and_access';
    }
}
