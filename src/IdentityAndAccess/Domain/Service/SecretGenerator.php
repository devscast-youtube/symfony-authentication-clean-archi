<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Service;

use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedCode;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;

/**
 * Class SecretGenerator.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface SecretGenerator
{
    public function generateToken(int $length = 60): GeneratedToken;

    public function generateCode(int $length = 6): GeneratedCode;
}
