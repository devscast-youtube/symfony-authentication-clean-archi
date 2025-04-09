<?php

declare(strict_types=1);

namespace Classroom\StudentManagement\Presentation\Web\Controller\Student;

use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Classroom\StudentManagement\Application\ReadModel\StudentList;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentList;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class GetStudentListController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/student', name: 'app_student_index', methods: ['GET'])]
final class GetStudentListController extends AbstractController
{
    public function __invoke(): Response
    {
        /** @var StudentList $students */
        $students = $this->handleQuery(new GetStudentList());

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }
}
