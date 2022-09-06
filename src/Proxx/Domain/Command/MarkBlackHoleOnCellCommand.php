<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;

/**
 * @class MarkBlackHoleOnCellCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class MarkBlackHoleOnCellCommand extends AbstractCommand
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
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY)
    {
		$this->processUuid = $processUuid;
		$this->uuid = $uuid;
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
