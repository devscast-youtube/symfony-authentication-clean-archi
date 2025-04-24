<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine;

use Symfony\Component\Uid\Uuid;

enum StudentCacheKeys: string
{
    case PROFILE = 'student-profile-%s';

    case LIST = 'student-list';

    public function withId(Uuid $id): string
    {
        return \sprintf($this->value, (string) $id);
    }
}
