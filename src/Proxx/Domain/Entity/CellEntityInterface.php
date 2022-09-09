<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use Micro\Game\Proxx\Domain\ValueObject\HasBlackHole;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\WasMarked;
use Micro\Game\Proxx\Domain\ValueObject\WasOpened;

/**
 * @interface CellEntityInterface
 *
 * @package Micro\Game\Proxx\Domain\Entity
 */
interface CellEntityInterface
{
    /**
     * Return position-x value object.
     */
    public function getPositionX(): ?PositionX;

    /**
     * Return position-y value object.
     */
    public function getPositionY(): ?PositionY;

    /**
     * Return has-black-hole value object.
     */
    public function getHasBlackHole(): ?HasBlackHole;

    /**
     * Has black hole in the cell.
     */
    public function hasBlackHole(): bool;

    /**
     * Return number-of-black-holes-around value object.
     */
    public function getNumberOfBlackHolesAround(): ?NumberOfBlackHolesAround;

    /**
     * Has black holes around.
     */
    public function hasBlackHolesAround(): bool;

    /**
     * Return was-opened value object.
     */
    public function getWasOpened(): ?WasOpened;

    /**
     * Is cell was opened.
     */
    public function isWasOpened(): bool;

    /**
     * Return was-marked value object.
     */
    public function getWasMarked(): ?WasMarked;

    /**
     * Is black hole marked on cell.
     */
    public function isBlackHoleMarked(): bool;

    /**
     * Execute create-cell command.
     */
    public function createCell(PositionX $positionX, PositionY $positionY);

    /**
     * Execute set-black-hole command.
     */
    public function setBlackHole();

    /**
     * Execute open command.
     */
    public function open();

    /**
     * Execute set-black-holes-around command.
     */
    public function setBlackHolesAround(NumberOfBlackHolesAround $numberOfBlackHolesAround);

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole();
}
