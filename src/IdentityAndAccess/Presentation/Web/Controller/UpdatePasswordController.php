<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Presentation\Web\Controller;

use Classroom\IdentityAndAccess\Application\UseCase\Command\UpdatePassword;
use Classroom\IdentityAndAccess\Presentation\Web\WriteModel\UpdatePasswordModel;
use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class UpdatePasswordController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/api/password/update', name: 'identity_and_access_update_password', methods: ['POST'])]
final class UpdatePasswordController extends AbstractController
{
    public function __invoke(#[MapRequestPayload] UpdatePasswordModel $model): JsonResponse
    {
        $securityUser = $this->getSecurityUser();
        $this->handleCommand(new UpdatePassword(
            $securityUser->userId,
            $model->current,
            $model->password
        ));

        return new JsonResponse(status: 200);
    }
}
