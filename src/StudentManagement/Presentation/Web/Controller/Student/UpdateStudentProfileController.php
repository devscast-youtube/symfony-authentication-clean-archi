<?php

namespace Classroom\StudentManagement\Presentation\Web\Controller\Student;

use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Classroom\StudentManagement\Application\UseCase\Command\UpdateStudentProfile;
use Classroom\StudentManagement\Domain\Exception\StudentNotFound;
use Classroom\StudentManagement\Domain\Model\Repository\StudentRepository;
use Classroom\StudentManagement\Presentation\Web\Form\StudentType;
use Classroom\StudentManagement\Presentation\WriteModel\StudentModel;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
final class UpdateStudentProfileController extends AbstractController
{
    public function __construct(
        private readonly StudentRepository $studentRepository
    ) {
    }

    public function __invoke(Request $request, int $id): Response
    {
        try {
            $student = $this->studentRepository->getById($id);
        } catch (StudentNotFound) {
            throw $this->createNotFoundException();
        }

        $model = StudentModel::createFromEntity($student);

        $form = $this->createForm(StudentType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handleCommand(new UpdateStudentProfile(
                    $student->id,
                    $model->email,
                    $model->username,
                    $model->address,
                    $model->birthdate
                ));
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());

                return $this->redirectToRoute('app_student_edit', [
                    'id' => $student->id,
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }
}
