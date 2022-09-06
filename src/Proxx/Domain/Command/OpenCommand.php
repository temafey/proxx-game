<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;

/**
 * @class OpenCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class OpenCommand extends AbstractCommand
{
    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid)
    {
		$this->processUuid = $processUuid;
		parent::__construct($processUuid, $uuid);
        
    }
}
