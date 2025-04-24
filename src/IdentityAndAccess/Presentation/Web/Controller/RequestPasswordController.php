<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Presentation\Web\Controller;

use Classroom\IdentityAndAccess\Application\UseCase\Command\RequestPassword;
use Classroom\IdentityAndAccess\Presentation\Web\WriteModel\RequestPasswordModel;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class RequestPasswordController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/api/password/request', name: 'identity_and_access_request_password', methods: ['POST'])]
final class RequestPasswordController extends AbstractController
{
    public function __invoke(#[MapRequestPayload] RequestPasswordModel $model): JsonResponse
    {
        $email = Email::from($model->email);
        $this->handleCommand(new RequestPassword($email));

        return new JsonResponse(status: 200);
    }
}
