<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @class SetBlackHoleCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class SetBlackHoleCommand extends AbstractCommand
{
    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, UuidInterface $uuid)
    {
		$this->processUuid = $processUuid;
		parent::__construct($processUuid, $uuid);
        
    }
}
