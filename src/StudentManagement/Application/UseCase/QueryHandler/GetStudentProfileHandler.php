<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Application\UseCase\QueryHandler;

use Classroom\SharedContext\Application\Messaging\QueryHandler;
use Classroom\StudentManagement\Application\ReadModel\StudentProfile;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentProfile;

interface GetStudentProfileHandler extends QueryHandler
{
    public function __invoke(GetStudentProfile $query): StudentProfile;
}
