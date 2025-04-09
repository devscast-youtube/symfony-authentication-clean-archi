<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Model\ValueObject;

/**
 * Class Address.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Address
{
    public function __construct(
        public ?string $city = null,
        public ?string $country = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null
    ) {
    }
}
