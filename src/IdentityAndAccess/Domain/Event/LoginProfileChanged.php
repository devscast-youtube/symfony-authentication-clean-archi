<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Event;

use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\SharedContext\Domain\Model\ValueObject\Tracking\Device;
use Classroom\SharedContext\Domain\Model\ValueObject\Tracking\GeoLocation;

/**
 * Class LoginProfileChanged.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class LoginProfileChanged
{
    public function __construct(
        public UserId $userId,
        public Device $device,
        public GeoLocation $location
    ) {
    }
}
