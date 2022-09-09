<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use Micro\Game\Proxx\Domain\ValueObject\GameStatus;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfMarkedBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfOpenedCells;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @interface BoardEntityInterface
 *
 * @package Micro\Game\Proxx\Domain\Entity
 */
interface BoardEntityInterface
{
    /**
     * Return width value object.
     */
    public function getWidth(): ?Width;

    /**
     * Return number-of-black-holes value object.
     */
    public function getNumberOfBlackHoles(): ?NumberOfBlackHoles;

    /**
     * Return number-of-opened-cells value object.
     */
    public function getNumberOfOpenedCells(): ?NumberOfOpenedCells;

    /**
     * Return number-of-marked-black-holes value object.
     */
    public function getNumberOfMarkedBlackHoles(): ?NumberOfMarkedBlackHoles;

    /**
     * Return game status.
     */
    public function getGameStatus(): GameStatus;

    /**
     * Return created_at value object.
     */
    public function getCreatedAt(): ?CreatedAt;

    /**
     * Return updated_at value object.
     */
    public function getUpdatedAt(): ?UpdatedAt;

    /**
     * Execute create-board command.
     */
    public function createBoard(ProcessUuid $processUuid, Board $board);

    /**
     * Execute set-cells command.
     */
    public function installCells(ProcessUuid $processUuid);

    /**
     * Execute set-black-holes command.
     */
    public function setBlackHoles(ProcessUuid $processUuid);

    /**
     * Execute calculate-black-holes-around command.
     */
    public function calculateBlackHolesAround(ProcessUuid $processUuid);

    /**
     * Execute open-cell command.
     */
    public function openCell(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY);

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY);

    /**
     * Execute unmark-black-hole command.
     */
    public function unmarkBlackHole(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY);

    /**
     * Execute process-game command.
     */
    public function processGame(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY);
}
