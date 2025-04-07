<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Domain\Service;

use Classroom\StudentManagement\Domain\Exception\CannotRegisterUnderage;
use Classroom\StudentManagement\Domain\Model\ValueObject\Age;

/**
 * Class AgeVerifier.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AgeVerifier
{
    private const int MAJORITY_THRESHOLD = 18;

    public function assertNotUnderage(\DateTimeImmutable $birthdate): void
    {
        $age = Age::fromDateTime($birthdate);
        $majority = Age::from(self::MAJORITY_THRESHOLD);

        if ($age->lowerThen($majority) && ! $age->equals($majority)) {
            throw CannotRegisterUnderage::with($age);
        }
    }
}
