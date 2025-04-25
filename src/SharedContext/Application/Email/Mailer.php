<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Application\Email;

/**
 * Interface Mailer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface Mailer
{
    public function send(EmailDefinition $email): void;
}
