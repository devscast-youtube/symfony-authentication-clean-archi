<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Domain;

use Classroom\SharedContext\Domain\Exception\InvalidArgument;

/**
 * Class Assert.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Assert extends \Webmozart\Assert\Assert
{
    #[\Override]
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgument($message);
    }
}
