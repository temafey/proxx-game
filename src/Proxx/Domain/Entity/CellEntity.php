<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\Serializer\Serializable;
use MicroModule\Common\Domain\Entity\EntityInterface;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\Common\Domain\ValueObject\Uuid;
use MicroModule\Snapshotting\EventSourcing\AggregateAssemblerInterface;
use MicroModule\ValueObject\ValueObjectInterface;
use Micro\Game\Proxx\Domain\Event\BlackHoleMarkedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleSetedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesAroundSetedEvent;
use Micro\Game\Proxx\Domain\Event\CellCreatedEvent;
use Micro\Game\Proxx\Domain\Event\OpenedEvent;
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
class CellEntity extends EventSourcedAggregateRoot implements CellEntityInterface, EntityInterface, AggregateAssemblerInterface, Serializable
{
    /**
     * EventFactory object.
     */
    protected EventFactoryInterface $eventFactory;

    /**
     * process_uuid value object.
     */
    protected ?ProcessUuid $processUuid = null;

    /**
     * uuid value object.
     */
    protected ?Uuid $uuid = null;

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
     * created_at value object.
     */
    protected ?CreatedAt $createdAt = null;

    /**
     * updated_at value object.
     */
    protected ?UpdatedAt $updatedAt = null;



    /**
     * Constructor
     */
    public function __construct(?EventFactoryInterface $eventFactory = null)
    {
		$this->eventFactory = $eventFactory ?? new EventFactory();
        
    }

    /**
     * Return process_uuid value object.
     */
    public function getProcessUuid(): ?ProcessUuid
    {
        return $this->processUuid;
    }

    /**
     * Return uuid value object.
     */
    public function getUuid(): ?Uuid
    {
        return $this->uuid;
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
     * Return number-of-black-holes-around value object.
     */
    public function getNumberOfBlackHolesAround(): ?NumberOfBlackHolesAround
    {
        return $this->numberOfBlackHolesAround;
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
     * Return created_at value object.
     */
    public function getCreatedAt(): ?CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * Return updated_at value object.
     */
    public function getUpdatedAt(): ?UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * Execute create-cell command.
     */
    public function createCell(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY): void
    {
		$this->apply($this->eventFactory->makeCellCreatedEvent($processUuid, $positionX, $positionY));
    }

    /**
     * Apply CellCreatedEvent event.
     */
    public function applyCellCreatedEvent(CellCreatedEvent $event): void
    {
		$this->positionX = $event->getPositionX();
		$this->positionY = $event->getPositionY();
    }

    /**
     * Execute set-black-hole command.
     */
    public function setBlackHole(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeBlackHoleSetedEvent($processUuid));
    }

    /**
     * Apply BlackHoleSetedEvent event.
     */
    public function applyBlackHoleSetedEvent(BlackHoleSetedEvent $event): void
    {
    }

    /**
     * Execute open command.
     */
    public function open(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeOpenedEvent($processUuid));
    }

    /**
     * Apply OpenedEvent event.
     */
    public function applyOpenedEvent(OpenedEvent $event): void
    {
    }

    /**
     * Execute set-black-holes-around command.
     */
    public function setBlackHolesAround(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround): void
    {
		$this->apply($this->eventFactory->makeBlackHolesAroundSetedEvent($processUuid, $numberOfBlackHolesAround));
    }

    /**
     * Apply BlackHolesAroundSetedEvent event.
     */
    public function applyBlackHolesAroundSetedEvent(BlackHolesAroundSetedEvent $event): void
    {
		$this->numberOfBlackHolesAround = $event->getNumberOfBlackHolesAround();
    }

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeBlackHoleMarkedEvent($processUuid));
    }

    /**
     * Apply BlackHoleMarkedEvent event.
     */
    public function applyBlackHoleMarkedEvent(BlackHoleMarkedEvent $event): void
    {
    }

    /**
     * Factory method for creating a new BoardEntity.
     */
    public static function create(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null, ?EventFactoryInterface $eventFactory = null): self
    {
		$entity = new static($eventFactory);
		$event = $entity->eventFactory->makeCreateBoardedEvent($processUuid, $uuid, $board);

		if ($payload !== null) {
			$event->setPayload($payload);
		}
		$entity->apply($event);

        return $entity;
    }

    /**
     * Factory method for creating a new CellEntity.
     */
    public static function createActual(Uuid $uuid, Cell $cell, ?EventFactoryInterface $eventFactory = null): self
    {
		$entity = new static($eventFactory);
		$entity->uuid = $uuid;
		$entity->assembleFromValueObject($cell);

        return $entity;
    }

    /**
     * Factory method for creating a new CellEntity.
     */
    public static function deserialize(array $data): self
    {
		Assertion::keyExists($data, self::KEY_UUID);
		$cell = Cell::fromNative($data);

        return static::createActual(Uuid::fromNative($data[self::KEY_UUID]), $cell);
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

		if (null !== $valueObject->getCreatedAt()) {
			$this->createdAt = $valueObject->getCreatedAt();
		}

		if (null !== $valueObject->getUpdatedAt()) {
			$this->updatedAt = $valueObject->getUpdatedAt();
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

		if (null !== $this->getProcessUuid()) {
			$data["process_uuid"] = $this->getProcessUuid()->toNative();
		}

		if (null !== $this->getUuid()) {
			$data["uuid"] = $this->getUuid()->toNative();
		}

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

		if (null !== $this->getCreatedAt()) {
			$data["created_at"] = $this->getCreatedAt()->toNative();
		}

		if (null !== $this->getUpdatedAt()) {
			$data["updated_at"] = $this->getUpdatedAt()->toNative();
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

    /**
     * Return current aggregate root unique key.
     */
    public function getAggregateRootId(): string
    {
        return $this->uuid->toNative();
    }

    /**
     * Return entity primary key value.
     */
    public function getPrimaryKeyValue(): string
    {
        return $this->getAggregateRootId();
    }
}
