<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\ValueObject\BlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\Cell;
use Micro\Game\Proxx\Domain\ValueObject\Cells;
use Micro\Game\Proxx\Domain\ValueObject\GameStatus;
use Micro\Game\Proxx\Domain\ValueObject\HasBlackHole;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfCells;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfMarkedBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfOpenedCells;
use Micro\Game\Proxx\Domain\ValueObject\OpenedCells;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\WasMarked;
use Micro\Game\Proxx\Domain\ValueObject\WasOpened;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @interface ValueObjectFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface ValueObjectFactoryInterface
{
    /**
     * Create Width ValueObject.
     */
    public function makeWidth(int $width): Width;

    /**
     * Create NumberOfBlackHoles ValueObject.
     */
    public function makeNumberOfBlackHoles(int $numberOfBlackHoles): NumberOfBlackHoles;

    /**
     * Create Cells ValueObject.
     */
    public function makeCells(array $cells): Cells;

    /**
     * Create OpenedCells ValueObject.
     */
    public function makeOpenedCells(array $openedCells): OpenedCells;

    /**
     * Create BlackHoles ValueObject.
     */
    public function makeBlackHoles(array $blackHoles): BlackHoles;

    /**
     * Create NumberOfCells ValueObject.
     */
    public function makeNumberOfCells(int $numberOfCells): NumberOfCells;

    /**
     * Create NumberOfOpenedCells ValueObject.
     */
    public function makeNumberOfOpenedCells(int $numberOfOpenedCells): NumberOfOpenedCells;

    /**
     * Create NumberOfMarkedBlackHoles ValueObject.
     */
    public function makeNumberOfMarkedBlackHoles(int $numberOfMarkedBlackHoles): NumberOfMarkedBlackHoles;

    /**
     * Create GameStatus ValueObject.
     */
    public function makeGameStatus(int $gameStatus): GameStatus;

    /**
     * Create PositionX ValueObject.
     */
    public function makePositionX(int $positionX): PositionX;

    /**
     * Create PositionY ValueObject.
     */
    public function makePositionY(int $positionY): PositionY;

    /**
     * Create HasBlackHole ValueObject.
     */
    public function makeHasBlackHole(): HasBlackHole;

    /**
     * Create NumberOfBlackHolesAround ValueObject.
     */
    public function makeNumberOfBlackHolesAround(int $numberOfBlackHolesAround): NumberOfBlackHolesAround;

    /**
     * Create WasOpened ValueObject.
     */
    public function makeWasOpened(): WasOpened;

    /**
     * Create WasMarked ValueObject.
     */
    public function makeWasMarked(): WasMarked;

    /**
     * Create Board ValueObject.
     */
    public function makeBoard(array $board): Board;

    /**
     * Create Cell ValueObject.
     */
    public function makeCell(array $cell): Cell;
}
