<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Presentation\Web\WriteModel;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestPasswordModel.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RequestPasswordModel
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}
