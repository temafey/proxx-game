<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Command;

use MicroModule\Base\Domain\Command\CommandInterface as BaseCommandInterface;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;

interface CommandInterface extends BaseCommandInterface
{
    /**
     * Get Process Uuid
     */
    public function getProcessUuid(): ProcessUuid;
}
