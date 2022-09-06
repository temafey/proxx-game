<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

use JsonException;
use MicroModule\Common\Infrastructure\Service\DataMapper\Exception\SourceValueIsInvalidException;

/**
 * Type that maps an array value
 */
class ArrayType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function convertToStorageValue(mixed $value): string
    {
        if (!is_array($value)) {
            throw SourceValueIsInvalidException::fromParameters(
                self::class,
                'array',
                gettype($value)
            );
        }

        return '{' . implode(',', $value) . '}';
    }

    /**
     * {@inheritdoc}
     *
     * @throws JsonException
     */
    public function convertFromStorageValue(mixed $value): array
    {
        if (!is_string($value)) {
            throw SourceValueIsInvalidException::fromParameters(
                self::class,
                'string',
                gettype($value)
            );
        }

        $convertedToJsonValue = strtr(
            $value,
            [
                '{' => '[',
                '}' => ']',
            ]
        );

        return (array)json_decode($convertedToJsonValue, true, 512, JSON_THROW_ON_ERROR);
    }
}
