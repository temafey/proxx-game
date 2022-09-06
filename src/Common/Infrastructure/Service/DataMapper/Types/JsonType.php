<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

use JsonException;
use MicroModule\Common\Infrastructure\Service\DataMapper\Exception\SourceValueIsInvalidException;

/**
 * Type that maps a json value
 */
class JsonType implements TypeInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws JsonException
     */
    public function convertToStorageValue(mixed $value): string
    {
        if (false === is_array($value)) {
            throw SourceValueIsInvalidException::fromParameters(
                self::class,
                'array',
                gettype($value)
            );
        }

        return (string)json_encode($value, JSON_THROW_ON_ERROR);
    }

    /**
     * {@inheritdoc}
     *
     * @throws JsonException
     */
    public function convertFromStorageValue(mixed $value): array
    {
        return (array)json_decode((string)$value, true, 512, JSON_THROW_ON_ERROR);
    }
}
