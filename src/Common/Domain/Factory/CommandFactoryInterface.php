<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Factory;

use MicroModule\Base\Domain\Factory\CommandFactoryInterface as BaseCommandFactoryInterface;

interface CommandFactoryInterface extends BaseCommandFactoryInterface
{
    /**
     * Check if command is allowed for current factory
     */
    public function isCommandAllowed(string $commandType): bool;
}
