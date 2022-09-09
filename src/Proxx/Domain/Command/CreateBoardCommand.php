<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @class CreateBoardCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class CreateBoardCommand extends AbstractCommand
{
    /**
     *  value object.
     */
    protected Width $width;

    /**
     *  value object.
     */
    protected NumberOfBlackHoles $numberOfBlackHoles;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Width $width, NumberOfBlackHoles $numberOfBlackHoles)
    {
		$this->processUuid = $processUuid;
		$this->uuid = $uuid;
		$this->width = $width;
		$this->numberOfBlackHoles = $numberOfBlackHoles;
		parent::__construct($processUuid, $uuid);
        
    }

    /**
     * Return Width value object.
     */
    public function getWidth(): Width
    {
        return $this->width;
    }

    /**
     * Return NumberOfBlackHoles value object.
     */
    public function getNumberOfBlackHoles(): NumberOfBlackHoles
    {
        return $this->numberOfBlackHoles;
    }
}
