<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\Email;

use Classroom\SharedContext\Application\Email\EmailDefinition;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class PasswordResetEmail.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PasswordResetEmail implements EmailDefinition
{
    public function __construct(
        private Email $recipient,
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
        return 'identity_and_access.emails.subjects.password_reset';
    }

    #[\Override]
    public function subjectVariables(): array
    {
        return [];
    }

    #[\Override]
    public function template(): string
    {
        return 'identity_and_access/password_reset';
    }

    #[\Override]
    public function templateVariables(): array
    {
        return [];
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
