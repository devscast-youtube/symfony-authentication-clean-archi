<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\Email;

use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;
use Classroom\SharedContext\Application\Email\EmailDefinition;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class UserRegisteredEmail.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ConfirmationRequestedEmail implements EmailDefinition
{
    public function __construct(
        private Email $recipient,
        private string $name,
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
        return 'identity_and_access.emails.subjects.user_registered';
    }

    #[\Override]
    public function subjectVariables(): array
    {
        return [];
    }

    #[\Override]
    public function template(): string
    {
        return 'identity_and_access/user_registered';
    }

    #[\Override]
    public function templateVariables(): array
    {
        return [
            'name' => $this->name,
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
