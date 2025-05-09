<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Infrastructure\Persistence\Doctrine\DBAL\Types;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * Class EmailType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailType extends Type
{
    public const string NAME = 'email';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 500,
        ]);
    }

    #[\Override]
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Email
    {
        if ($value === null) {
            return null;
        }

        if (! \is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string', Email::class]);
        }

        try {
            return new Email($value);
        } catch (\Throwable $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    #[\Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Email) {
            return (string) $value;
        }

        if ($value === null || $value === '') {
            return null;
        }

        if (! \is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string', Email::class]);
        }

        try {
            return (string) new Email($value);
        } catch (\Throwable $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }
}
