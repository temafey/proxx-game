<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

interface TypeInterface
{
    /**
     * Return value converted to storage format.
     */
    public function convertToStorageValue(mixed $value): mixed;

    /**
     * Return value converted from storage format.
     */
    public function convertFromStorageValue(mixed $value): mixed;
}
