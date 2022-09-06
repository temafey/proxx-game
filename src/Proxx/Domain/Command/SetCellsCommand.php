<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;

/**
 * @class SetCellsCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class SetCellsCommand extends AbstractCommand
{
    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid)
    {
		$this->processUuid = $processUuid;
		$this->uuid = $uuid;
		parent::__construct($processUuid, $uuid);
        
    }
}
