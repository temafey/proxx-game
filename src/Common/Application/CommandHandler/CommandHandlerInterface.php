<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;

interface CommandHandlerInterface
{
    /**
     * Handle specific command
     */
    public function handle(CommandInterface $command);
}

