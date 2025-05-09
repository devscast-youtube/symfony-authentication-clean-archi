<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret;

use Classroom\SharedContext\Domain\Assert;

/**
 * Class GeneratedCode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class GeneratedCode implements \Stringable
{
    public function __construct(
        public string $code
    ) {
        Assert::notEmpty($this->code);
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->code;
    }
}
