<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Infrastructure\Persistence\Doctrine\DBAL\Types;

use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

/**
 * Class StudentId.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class StudentIdType extends AbstractUidType
{
    #[\Override]
    public function getName(): string
    {
        return 'student_id';
    }

    #[\Override]
    protected function getUidClass(): string
    {
        return StudentId::class;
    }
}
