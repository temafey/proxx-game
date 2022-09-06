<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;

/**
 * @class SetBlackHolesAroundCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class SetBlackHolesAroundCommand extends AbstractCommand
{
    /**
     *  value object.
     */
    protected NumberOfBlackHolesAround $numberOfBlackHolesAround;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround)
    {
		$this->processUuid = $processUuid;
		$this->numberOfBlackHolesAround = $numberOfBlackHolesAround;
		parent::__construct($processUuid, $uuid);
        
    }

    /**
     * Return NumberOfBlackHolesAround value object.
     */
    public function getNumberOfBlackHolesAround(): NumberOfBlackHolesAround
    {
        return $this->numberOfBlackHolesAround;
    }
}
