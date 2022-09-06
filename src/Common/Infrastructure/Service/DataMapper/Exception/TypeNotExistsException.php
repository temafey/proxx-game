<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Exception;

use RuntimeException;

/**
 * Exception thrown if type is not found
 */
class TypeNotExistsException extends RuntimeException
{
    /**
     * TypeDoesNotExistsException factory method
     */
    public static function fromTypeClass(string $type): self
    {
        return new self(sprintf("Type '%s' does not exists", $type));
    }
}
