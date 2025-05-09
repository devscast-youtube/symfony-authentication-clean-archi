<?php

declare(strict_types=1);

namespace Classroom\IdentityAndAccess\Domain\Model\Entity;

use Classroom\IdentityAndAccess\Domain\Event\AccountConfirmed;
use Classroom\IdentityAndAccess\Domain\Event\AccountLocked;
use Classroom\IdentityAndAccess\Domain\Event\AccountUnlocked;
use Classroom\IdentityAndAccess\Domain\Event\ConfirmationRequested;
use Classroom\IdentityAndAccess\Domain\Event\EmailUpdated;
use Classroom\IdentityAndAccess\Domain\Event\PasswordCreated;
use Classroom\IdentityAndAccess\Domain\Event\PasswordForgotten;
use Classroom\IdentityAndAccess\Domain\Event\PasswordReset;
use Classroom\IdentityAndAccess\Domain\Event\PasswordUpdated;
use Classroom\IdentityAndAccess\Domain\Exception\InvalidCurrentPassword;
use Classroom\IdentityAndAccess\Domain\Exception\PasswordAlreadyDefined;
use Classroom\IdentityAndAccess\Domain\Model\Entity\Identity\UserId;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Roles;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Secret\GeneratedCode;
use Classroom\IdentityAndAccess\Domain\Service\PasswordHasher;
use Classroom\SharedContext\Domain\EventDispatcher\EventEmitterTrait;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;

/**
 * Class User.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class User
{
    use EventEmitterTrait;

    public readonly UserId $id;

    private function __construct(
        private(set) string $name,
        private(set) Email $email,
        private(set) Roles $roles,
        private(set) ?string $password = null,
        private(set) bool $isLocked = false,
        private(set) bool $isConfirmed = false,
        private(set) ?\DateTimeImmutable $updatedAt = null,
        public readonly ?\DateTimeImmutable $createdAt = new \DateTimeImmutable(),
    ) {
        $this->id = new UserId();
    }

    public function lockAccount(VerificationToken $verificationToken): self
    {
        $this->isLocked = true;
        $this->emitEvent(new AccountLocked($this->id, $verificationToken->token));

        return $this;
    }

    public function unlockAccount(): self
    {
        $this->isLocked = false;
        $this->emitEvent(new AccountUnlocked($this->id));

        return $this;
    }

    public function confirmAccount(): self
    {
        $this->isConfirmed = true;
        $this->emitEvent(new AccountConfirmed($this->id));

        return $this;
    }

    public static function register(string $name, Email $email, ?Roles $roles): self
    {
        return new self($name, $email, $roles ?? Roles::user());
    }

    public function updateProfile(string $name, Roles $roles): static
    {
        $this->name = $name;
        $this->roles = $roles;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function updateEmail(Email $email): self
    {
        $previous = $this->email;
        $this->email = $email;
        $this->emitEvent(new EmailUpdated($this->id, $previous, $email));

        return $this;
    }

    public function resetPassword(string $password, PasswordHasher $passwordHasher): void
    {
        $this->password = $passwordHasher->hash($this, $password);
        $this->emitEvent(new PasswordReset($this->id));
    }

    public function updatePassword(string $current, string $new, PasswordHasher $passwordHasher): self
    {
        if ($this->password === null || ! $passwordHasher->verify($this, $current)) {
            throw new InvalidCurrentPassword();
        }

        $this->password = $passwordHasher->hash($this, $new);
        $this->emitEvent(new PasswordUpdated($this->id));

        return $this;
    }

    public function definePassword(GeneratedCode|string $password, PasswordHasher $passwordHasher): self
    {
        if ($this->password !== null) {
            throw new PasswordAlreadyDefined();
        }

        $this->password = $passwordHasher->hash($this, (string) $password);
        $this->updatedAt = new \DateTimeImmutable();

        if ($password instanceof GeneratedCode) {
            $this->emitEvent(new PasswordCreated($this->id, $password));
        }

        return $this;
    }

    public function requestPasswordReset(VerificationToken $verificationToken): self
    {
        $this->emitEvent(new PasswordForgotten($this->id, $verificationToken->token));

        return $this;
    }

    public function requestAccountConfirmation(VerificationToken $verificationToken): self
    {
        $this->emitEvent(new ConfirmationRequested($this->id, $verificationToken->token));

        return $this;
    }
}
