<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\Board;

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
    protected Board $board;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Board $board)
    {
		$this->processUuid = $processUuid;
		$this->uuid = $uuid;
		$this->board = $board;
		parent::__construct($processUuid, $uuid);
        
    }

    /**
     * Return Board value object.
     */
    public function getBoard(): Board
    {
        return $this->board;
    }
}
