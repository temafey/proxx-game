<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Query;

use MicroModule\Base\Domain\Command\CommandInterface as BaseQueryInterface;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;

interface QueryInterface extends BaseQueryInterface
{
    /**
     * Get Process uuid value object
     */
    public function getProcessUuid(): ProcessUuid;
}
