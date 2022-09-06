<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\Cell;
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
     * Return number-of-black-holes-around value object.
     */
    public function getNumberOfBlackHolesAround(): ?NumberOfBlackHolesAround;

    /**
     * Return was-opened value object.
     */
    public function getWasOpened(): ?WasOpened;

    /**
     * Return was-marked value object.
     */
    public function getWasMarked(): ?WasMarked;

    /**
     * Return created_at value object.
     */
    public function getCreatedAt(): ?CreatedAt;

    /**
     * Return updated_at value object.
     */
    public function getUpdatedAt(): ?UpdatedAt;

    /**
     * Execute create-cell command.
     */
    public function createCell(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY);

    /**
     * Execute set-black-hole command.
     */
    public function setBlackHole(ProcessUuid $processUuid);

    /**
     * Execute open command.
     */
    public function open(ProcessUuid $processUuid);

    /**
     * Execute set-black-holes-around command.
     */
    public function setBlackHolesAround(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround);

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole(ProcessUuid $processUuid);
}
