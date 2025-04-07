<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Domain\Model\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Class Email.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class Email implements \Stringable
{
    public string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::email($value);

        $this->value = $value;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
