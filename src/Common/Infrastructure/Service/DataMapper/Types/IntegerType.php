<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

/**
 * Type that maps an integer value
 */
class IntegerType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function convertToStorageValue(mixed $value): int
    {
        return (int)$value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertFromStorageValue(mixed $value): int
    {
        return (int)$value;
    }
}
