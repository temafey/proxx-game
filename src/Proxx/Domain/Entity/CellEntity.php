<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use Broadway\EventSourcing\SimpleEventSourcedEntity;
use Broadway\Serializer\Serializable;
use Micro\Game\Proxx\Domain\Factory\ValueObjectFactory;
use Micro\Game\Proxx\Domain\Factory\ValueObjectFactoryInterface;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Snapshotting\EventSourcing\AggregateAssemblerInterface;
use MicroModule\ValueObject\ValueObjectInterface;
use Micro\Game\Proxx\Domain\Factory\EventFactory;
use Micro\Game\Proxx\Domain\Factory\EventFactoryInterface;
use Micro\Game\Proxx\Domain\ValueObject\Cell;
use Micro\Game\Proxx\Domain\ValueObject\HasBlackHole;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\WasMarked;
use Micro\Game\Proxx\Domain\ValueObject\WasOpened;

/**
 * @class CellEntity
 *
 * @package Micro\Game\Proxx\Domain\Entity
 */
class CellEntity extends SimpleEventSourcedEntity implements CellEntityInterface, AggregateAssemblerInterface, Serializable
{
    /**
     * EventFactory object.
     */
    protected EventFactoryInterface $eventFactory;

    /**
     * ValueObjectFactory object.
     */
    protected ?ValueObjectFactoryInterface $valueObjectFactory;

    /**
     * position-x value object.
     */
    protected ?PositionX $positionX = null;

    /**
     * position-y value object.
     */
    protected ?PositionY $positionY = null;

    /**
     * has-black-hole value object.
     */
    protected ?HasBlackHole $hasBlackHole = null;

    /**
     * number-of-black-holes-around value object.
     */
    protected ?NumberOfBlackHolesAround $numberOfBlackHolesAround = null;

    /**
     * was-opened value object.
     */
    protected ?WasOpened $wasOpened = null;

    /**
     * was-marked value object.
     */
    protected ?WasMarked $wasMarked = null;

    /**
     * Constructor
     */
    public function __construct(
        ?EventFactoryInterface $eventFactory = null,
        ?ValueObjectFactoryInterface $valueObjectFactory = null
    ) {
        $this->eventFactory = $eventFactory ?? new EventFactory();
        $this->valueObjectFactory = $valueObjectFactory ?? new ValueObjectFactory();
    }

    /**
     * Return position-x value object.
     */
    public function getPositionX(): ?PositionX
    {
        return $this->positionX;
    }

    /**
     * Return position-y value object.
     */
    public function getPositionY(): ?PositionY
    {
        return $this->positionY;
    }

    /**
     * Return has-black-hole value object.
     */
    public function getHasBlackHole(): ?HasBlackHole
    {
        return $this->hasBlackHole;
    }

    /**
     * Has black hole in the cell.
     */
    public function hasBlackHole(): bool
    {
        return $this->hasBlackHole instanceof HasBlackHole;
    }

    /**
     * Return number-of-black-holes-around value object.
     */
    public function getNumberOfBlackHolesAround(): ?NumberOfBlackHolesAround
    {
        return $this->numberOfBlackHolesAround;
    }

    /**
     * Has black holes around.
     */
    public function hasBlackHolesAround(): bool
    {
        return $this->numberOfBlackHolesAround !== null &&
            $this->numberOfBlackHolesAround->toNative() > 0;
    }

    /**
     * Return was-opened value object.
     */
    public function getWasOpened(): ?WasOpened
    {
        return $this->wasOpened;
    }

    /**
     * Return was-marked value object.
     */
    public function getWasMarked(): ?WasMarked
    {
        return $this->wasMarked;
    }

    /**
     * Execute create-cell command.
     */
    public function createCell(PositionX $positionX, PositionY $positionY): void
    {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    /**
     * Execute set-black-hole command.
     */
    public function setBlackHole(): void
    {
        $this->hasBlackHole = $this->valueObjectFactory->makeHasBlackHole();
    }

    /**
     * Execute open command.
     */
    public function open(): void
    {
        $this->wasOpened = $this->valueObjectFactory->makeWasOpened();
    }

    /**
     * Is cell was opened.
     */
    public function isWasOpened(): bool
    {
        return $this->wasOpened instanceof WasOpened;
    }

    /**
     * Execute set-black-holes-around command.
     */
    public function setBlackHolesAround(NumberOfBlackHolesAround $numberOfBlackHolesAround): void
    {
		$this->numberOfBlackHolesAround = $numberOfBlackHolesAround;
    }

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole(): void
    {
		$this->wasMarked = $this->valueObjectFactory->makeWasMarked();
    }

    /**
     * Execute unmark-black-hole command.
     */
    public function unmarkBlackHole(): void
    {
        $this->wasMarked = null;
    }

    /**
     * Is black hole marked on cell.
     */
    public function isBlackHoleMarked(): bool
    {
        return $this->wasMarked instanceof WasMarked;
    }

    /**
     * Factory method for creating a new CellEntity.
     */
    public static function create(Cell $cell, ?EventFactoryInterface $eventFactory = null, ?ValueObjectFactoryInterface $valueObjectFactory = null): self
    {
		$entity = new static($eventFactory, $valueObjectFactory);
        $entity->assembleFromValueObject($cell);

        return $entity;
    }

    /**
     * Factory method for creating a new CellEntity.
     */
    public static function createActual(Cell $cell, ?EventFactoryInterface $eventFactory = null): self
    {
		$entity = new static($eventFactory);
		$entity->assembleFromValueObject($cell);

        return $entity;
    }

    /**
     * Factory method for creating a new CellEntity.
     */
    public static function deserialize(array $data): self
    {
		$cell = Cell::fromNative($data);

        return static::createActual($cell);
    }

    /**
     * Assemble entity from value object.
     */
    public function assembleFromValueObject(ValueObjectInterface $valueObject): void
    {
		if (!$valueObject instanceof Cell) {
			throw new ValueObjectInvalidException('CellEntity can be assembled only with Cell value object');
		}

		if (null !== $valueObject->getPositionX()) {
			$this->positionX = $valueObject->getPositionX();
		}

		if (null !== $valueObject->getPositionY()) {
			$this->positionY = $valueObject->getPositionY();
		}

		if (null !== $valueObject->getHasBlackHole()) {
			$this->hasBlackHole = $valueObject->getHasBlackHole();
		}

		if (null !== $valueObject->getNumberOfBlackHolesAround()) {
			$this->numberOfBlackHolesAround = $valueObject->getNumberOfBlackHolesAround();
		}

		if (null !== $valueObject->getWasOpened()) {
			$this->wasOpened = $valueObject->getWasOpened();
		}

		if (null !== $valueObject->getWasMarked()) {
			$this->wasMarked = $valueObject->getWasMarked();
		}
    }

    /**
     * Assemble value object from entity.
     */
    public function assembleToValueObject(): ValueObjectInterface
    {
		$cell = $this->normalize();

        return Cell::fromNative($cell);
    }

    /**
     * Convert entity object to array.
     */
    public function normalize(): array
    {
		$data = [];

		if (null !== $this->getPositionX()) {
			$data["position-x"] = $this->getPositionX()->toNative();
		}

		if (null !== $this->getPositionY()) {
			$data["position-y"] = $this->getPositionY()->toNative();
		}

		if (null !== $this->getHasBlackHole()) {
			$data["has-black-hole"] = $this->getHasBlackHole()->toNative();
		}

		if (null !== $this->getNumberOfBlackHolesAround()) {
			$data["number-of-black-holes-around"] = $this->getNumberOfBlackHolesAround()->toNative();
		}

		if (null !== $this->getWasOpened()) {
			$data["was-opened"] = $this->getWasOpened()->toNative();
		}

		if (null !== $this->getWasMarked()) {
			$data["was-marked"] = $this->getWasMarked()->toNative();
		}

        return $data;
    }

   /**
    * Converting an object into an array.
    */
    public function serialize(): array
    {
        return $this->normalize();
    }
}
