<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Common\Domain\Factory\CommonValueObjectFactory;
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
use MicroModule\Common\Domain\Factory\CommonValueObjectFactoryInterface;

/**
 * @class ValueObjectFactory
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
class ValueObjectFactory extends CommonValueObjectFactory implements ValueObjectFactoryInterface, CommonValueObjectFactoryInterface
{
    /**
     * Create Width ValueObject.
     */
    public function makeWidth(int $width): Width
    {
        return Width::fromNative($width);
    }

    /**
     * Create NumberOfBlackHoles ValueObject.
     */
    public function makeNumberOfBlackHoles(int $numberOfBlackHoles): NumberOfBlackHoles
    {
        return NumberOfBlackHoles::fromNative($numberOfBlackHoles);
    }

    /**
     * Create Cells ValueObject.
     */
    public function makeCells(array $cells): Cells
    {
        return Cells::fromNative($cells);
    }

    /**
     * Create OpenedCells ValueObject.
     */
    public function makeOpenedCells(array $openedCells): OpenedCells
    {
        return OpenedCells::fromNative($openedCells);
    }

    /**
     * Create BlackHoles ValueObject.
     */
    public function makeBlackHoles(array $blackHoles): BlackHoles
    {
        return BlackHoles::fromNative($blackHoles);
    }

    /**
     * Create NumberOfCells ValueObject.
     */
    public function makeNumberOfCells(int $numberOfCells): NumberOfCells
    {
        return NumberOfCells::fromNative($numberOfCells);
    }

    /**
     * Create NumberOfOpenedCells ValueObject.
     */
    public function makeNumberOfOpenedCells(int $numberOfOpenedCells): NumberOfOpenedCells
    {
        return NumberOfOpenedCells::fromNative($numberOfOpenedCells);
    }

    /**
     * Create NumberOfMarkedBlackHoles ValueObject.
     */
    public function makeNumberOfMarkedBlackHoles(int $numberOfMarkedBlackHoles): NumberOfMarkedBlackHoles
    {
        return NumberOfMarkedBlackHoles::fromNative($numberOfMarkedBlackHoles);
    }

    /**
     * Create GameStatus ValueObject.
     */
    public function makeGameStatus(int $gameStatus): GameStatus
    {
        return GameStatus::fromNative($gameStatus);
    }

    /**
     * Create PositionX ValueObject.
     */
    public function makePositionX(int $positionX): PositionX
    {
        return PositionX::fromNative($positionX);
    }

    /**
     * Create PositionY ValueObject.
     */
    public function makePositionY(int $positionY): PositionY
    {
        return PositionY::fromNative($positionY);
    }

    /**
     * Create HasBlackHole ValueObject.
     */
    public function makeHasBlackHole(): HasBlackHole
    {
        return HasBlackHole::fromNative();
    }

    /**
     * Create NumberOfBlackHolesAround ValueObject.
     */
    public function makeNumberOfBlackHolesAround(int $numberOfBlackHolesAround): NumberOfBlackHolesAround
    {
        return NumberOfBlackHolesAround::fromNative($numberOfBlackHolesAround);
    }

    /**
     * Create WasOpened ValueObject.
     */
    public function makeWasOpened(): WasOpened
    {
        return WasOpened::fromNative();
    }

    /**
     * Create WasMarked ValueObject.
     */
    public function makeWasMarked(): WasMarked
    {
        return WasMarked::fromNative();
    }

    /**
     * Create Board ValueObject.
     */
    public function makeBoard(array $board): Board
    {
        return Board::fromNative($board);
    }

    /**
     * Create Cell ValueObject.
     */
    public function makeCell(array $cell): Cell
    {
        return Cell::fromNative($cell);
    }
}
