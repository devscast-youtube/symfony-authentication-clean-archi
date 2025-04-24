<?php

namespace Classroom\StudentManagement\Presentation\Web\Controller\Student;

use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Classroom\StudentManagement\Application\ReadModel\StudentProfile;
use Classroom\StudentManagement\Application\UseCase\Query\GetStudentProfile;
use Classroom\StudentManagement\Domain\Exception\StudentNotFound;
use Classroom\StudentManagement\Domain\Model\Entity\Identity\StudentId;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/student/{id}', name: 'app_student_show', requirements: [
    'id' => Requirement::UUID,
], methods: ['GET'])]
final class GetStudentProfileController extends AbstractController
{
    public function __invoke(StudentId $id): Response
    {
        try {
            /** @var StudentProfile $student */
            $student = $this->handleQuery(new GetStudentProfile($id));
        } catch (StudentNotFound) {
            throw $this->createNotFoundException();
        }

        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }
}
