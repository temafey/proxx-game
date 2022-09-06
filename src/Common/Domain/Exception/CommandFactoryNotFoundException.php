<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Exception;

use RuntimeException;

class CommandFactoryNotFoundException extends RuntimeException
{
    public static function fromCommandType(string $commandType): self
    {
        return new self(sprintf('Command factory for command type `%s` does not exists', $commandType));
    }
}
