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
use Micro\Game\Proxx\Domain\Event\AroundBlackHolesFoundedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleMarkedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesSetedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellOpenedEvent;
use Micro\Game\Proxx\Domain\Event\CellsSetedEvent;
use Micro\Game\Proxx\Domain\Factory\EventFactory;
use Micro\Game\Proxx\Domain\Factory\EventFactoryInterface;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfMarkedBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfOpenedCells;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @class BoardEntity
 *
 * @package Micro\Game\Proxx\Domain\Entity
 */
class BoardEntity extends EventSourcedAggregateRoot implements BoardEntityInterface, EntityInterface, AggregateAssemblerInterface, Serializable
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
     * width value object.
     */
    protected ?Width $width = null;

    /**
     * number-of-black-holes value object.
     */
    protected ?NumberOfBlackHoles $numberOfBlackHoles = null;

    /**
     * number-of-opened-cells value object.
     */
    protected ?NumberOfOpenedCells $numberOfOpenedCells = null;

    /**
     * number-of-marked-black-holes value object.
     */
    protected ?NumberOfMarkedBlackHoles $numberOfMarkedBlackHoles = null;

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
     * Return width value object.
     */
    public function getWidth(): ?Width
    {
        return $this->width;
    }

    /**
     * Return number-of-black-holes value object.
     */
    public function getNumberOfBlackHoles(): ?NumberOfBlackHoles
    {
        return $this->numberOfBlackHoles;
    }

    /**
     * Return number-of-opened-cells value object.
     */
    public function getNumberOfOpenedCells(): ?NumberOfOpenedCells
    {
        return $this->numberOfOpenedCells;
    }

    /**
     * Return number-of-marked-black-holes value object.
     */
    public function getNumberOfMarkedBlackHoles(): ?NumberOfMarkedBlackHoles
    {
        return $this->numberOfMarkedBlackHoles;
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
     * Execute create-board command.
     */
    public function createBoard(ProcessUuid $processUuid, Board $board): void
    {
		$this->apply($this->eventFactory->makeBoardCreatedEvent($processUuid, $this->uuid, $board));
    }

    /**
     * Apply BoardCreatedEvent event.
     */
    public function applyBoardCreatedEvent(BoardCreatedEvent $event): void
    {
		$this->assembleFromValueObject($event->getBoard());
    }

    /**
     * Execute set-cells command.
     */
    public function setCells(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeCellsSetedEvent($processUuid, $this->uuid));
    }

    /**
     * Apply CellsSetedEvent event.
     */
    public function applyCellsSetedEvent(CellsSetedEvent $event): void
    {
		$this->assembleFromValueObject($event->getBoard());
    }

    /**
     * Execute set-black-holes command.
     */
    public function setBlackHoles(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeBlackHolesSetedEvent($processUuid, $this->uuid));
    }

    /**
     * Apply BlackHolesSetedEvent event.
     */
    public function applyBlackHolesSetedEvent(BlackHolesSetedEvent $event): void
    {
		$this->assembleFromValueObject($event->getBoard());
    }

    /**
     * Execute find-black-holes-around command.
     */
    public function findBlackHolesAround(ProcessUuid $processUuid): void
    {
		$this->apply($this->eventFactory->makeAroundBlackHolesFoundedEvent($processUuid, $this->uuid));
    }

    /**
     * Apply AroundBlackHolesFoundedEvent event.
     */
    public function applyAroundBlackHolesFoundedEvent(AroundBlackHolesFoundedEvent $event): void
    {
		$this->assembleFromValueObject($event->getBoard());
    }

    /**
     * Execute open-cell command.
     */
    public function openCell(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY): void
    {
		$this->apply($this->eventFactory->makeCellOpenedEvent($processUuid, $this->uuid, $positionX, $positionY));
    }

    /**
     * Apply CellOpenedEvent event.
     */
    public function applyCellOpenedEvent(CellOpenedEvent $event): void
    {
		$this->positionX = $event->getPositionX();
		$this->positionY = $event->getPositionY();
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
     * Factory method for creating a new BoardEntity.
     */
    public static function createActual(Uuid $uuid, Board $board, ?EventFactoryInterface $eventFactory = null): self
    {
		$entity = new static($eventFactory);
		$entity->uuid = $uuid;
		$entity->assembleFromValueObject($board);

        return $entity;
    }

    /**
     * Factory method for creating a new BoardEntity.
     */
    public static function deserialize(array $data): self
    {
		Assertion::keyExists($data, self::KEY_UUID);
		$board = Board::fromNative($data);

        return static::createActual(Uuid::fromNative($data[self::KEY_UUID]), $board);
    }

    /**
     * Assemble entity from value object.
     */
    public function assembleFromValueObject(ValueObjectInterface $valueObject): void
    {
		if (!$valueObject instanceof Board) {
			throw new ValueObjectInvalidException('BoardEntity can be assembled only with Board value object');
		}

		if (null !== $valueObject->getWidth()) {
			$this->width = $valueObject->getWidth();
		}

		if (null !== $valueObject->getNumberOfBlackHoles()) {
			$this->numberOfBlackHoles = $valueObject->getNumberOfBlackHoles();
		}

		if (null !== $valueObject->getNumberOfOpenedCells()) {
			$this->numberOfOpenedCells = $valueObject->getNumberOfOpenedCells();
		}

		if (null !== $valueObject->getNumberOfMarkedBlackHoles()) {
			$this->numberOfMarkedBlackHoles = $valueObject->getNumberOfMarkedBlackHoles();
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
		$board = $this->normalize();

        return Board::fromNative($board);
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

		if (null !== $this->getWidth()) {
			$data["width"] = $this->getWidth()->toNative();
		}

		if (null !== $this->getNumberOfBlackHoles()) {
			$data["number-of-black-holes"] = $this->getNumberOfBlackHoles()->toNative();
		}

		if (null !== $this->getNumberOfOpenedCells()) {
			$data["number-of-opened-cells"] = $this->getNumberOfOpenedCells()->toNative();
		}

		if (null !== $this->getNumberOfMarkedBlackHoles()) {
			$data["number-of-marked-black-holes"] = $this->getNumberOfMarkedBlackHoles()->toNative();
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
