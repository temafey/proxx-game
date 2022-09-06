<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

use MicroModule\Common\Infrastructure\Service\DataMapper\Exception\SourceValueIsInvalidException;

/**
 * Type that maps a bool value
 */
class BooleanType implements TypeInterface
{
    protected const STORAGE_VALUE_TRUE = 't';
    protected const STORAGE_VALUE_FALSE = 'f';

    /**
     * {@inheritdoc}
     */
    public function convertToStorageValue(mixed $value): string
    {
        if (!is_bool($value)) {
            throw SourceValueIsInvalidException::fromParameters(
                self::class,
                'boolean',
                gettype($value)
            );
        }

        return $value ? self::STORAGE_VALUE_TRUE : self::STORAGE_VALUE_FALSE;
    }

    /**
     * {@inheritdoc}
     */
    public function convertFromStorageValue(mixed $value): bool
    {
        return $value;
    }
}
