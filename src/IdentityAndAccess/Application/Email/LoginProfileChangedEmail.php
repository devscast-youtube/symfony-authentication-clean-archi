<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Application\Email;

use Classroom\SharedContext\Application\Email\EmailDefinition;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\SharedContext\Domain\Model\ValueObject\Tracking\Device;
use Classroom\SharedContext\Domain\Model\ValueObject\Tracking\GeoLocation;

/**
 * Class LoginProfileChangedEmail.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class LoginProfileChangedEmail implements EmailDefinition
{
    public function __construct(
        private Email $recipient,
        private Device $device,
        private GeoLocation $location
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
        return 'identity_and_access.emails.subjects.login_profile_changed';
    }

    #[\Override]
    public function subjectVariables(): array
    {
        return [];
    }

    #[\Override]
    public function template(): string
    {
        return 'identity_and_access/login_profile_changed';
    }

    #[\Override]
    public function templateVariables(): array
    {
        return [
            'device' => $this->device,
            'location' => $this->location,
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
