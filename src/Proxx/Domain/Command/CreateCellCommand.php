<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;

/**
 * @class CreateCellCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class CreateCellCommand extends AbstractCommand
{
    /**
     *  value object.
     */
    protected PositionX $positionX;

    /**
     *  value object.
     */
    protected PositionY $positionY;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY)
    {
		$this->processUuid = $processUuid;
		$this->positionX = $positionX;
		$this->positionY = $positionY;
		parent::__construct($processUuid, $uuid);
        
    }

    /**
     * Return PositionX value object.
     */
    public function getPositionX(): PositionX
    {
        return $this->positionX;
    }

    /**
     * Return PositionY value object.
     */
    public function getPositionY(): PositionY
    {
        return $this->positionY;
    }
}
