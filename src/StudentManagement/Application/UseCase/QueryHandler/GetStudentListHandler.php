<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Application\UseCase\QueryHandler;

use Classroom\SharedContext\Application\Messaging\QueryHandler;
use Classroom\StudentManagement\Application\ReadModel\StudentList;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentList;

interface GetStudentListHandler extends QueryHandler
{
    public function __invoke(GetStudentList $query): StudentList;
}
