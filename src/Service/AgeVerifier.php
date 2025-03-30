<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ValueObject\Age;
use App\Exception\CannotRegisterUnderage;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

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
