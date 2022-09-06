<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Exception;

use RuntimeException;

/**
 * Exception thrown source value for mapping is invalid.
 */
class SourceValueIsInvalidException extends RuntimeException
{
    /**
     * SourceValueIsInvalidException factory method
     */
    public static function fromParameters(string $classType, string $expectedType, string $givenType): self
    {
        return new self(
            sprintf(
                'Source value for %s is invalid. Expected type: %s, given type: %s',
                $classType,
                $expectedType,
                $givenType
            )
        );
    }
}
