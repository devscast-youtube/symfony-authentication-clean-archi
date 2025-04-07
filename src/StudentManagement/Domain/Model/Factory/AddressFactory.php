<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Model\Factory;

use Classroom\StudentManagement\Domain\Model\ValueObject\Address;

/**
 * Class AddressFactory.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface AddressFactory
{
    public function create(
        ?string $city = null,
        ?string $country = null,
        ?string $addressLine1 = null,
        ?string $addressLine2 = null
    ): Address;
}
