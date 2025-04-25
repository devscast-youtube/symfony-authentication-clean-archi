<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Presentation\Web\Controller;

use Classroom\IdentityAndAccess\Application\UseCase\Command\Register;
use Classroom\IdentityAndAccess\Presentation\Web\WriteModel\RegisterModel;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class RegisterController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/api/register', name: 'identity_and_access_register', methods: ['POST'])]
final class RegisterController extends AbstractController
{
    public function __invoke(#[MapRequestPayload] RegisterModel $model): JsonResponse
    {
        $this->handleCommand(new Register(
            $model->name,
            new Email($model->email),
            $model->password
        ));

        return new JsonResponse(status: 201);
    }
}
