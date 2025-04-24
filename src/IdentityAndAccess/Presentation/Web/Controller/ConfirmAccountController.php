<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Presentation\Web\Controller;

use Classroom\IdentityAndAccess\Application\UseCase\Command\ConfirmAccount;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedToken;
use Classroom\SharedContext\Presentation\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class UnlockAccountController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/api/account/confirm/{token}', name: 'identity_and_access_confirm_account', methods: ['GET'])]
final class ConfirmAccountController extends AbstractController
{
    public function __invoke(string $token): JsonResponse
    {
        $token = new GeneratedToken($token);
        $this->handleCommand(new ConfirmAccount($token));

        return new JsonResponse(status: 200);
    }
}
