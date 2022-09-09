<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Entity;

use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\EventSourcing\EventSourcedEntity;
use Broadway\Serializer\Serializable;
use Micro\Game\Proxx\Domain\Event\AroundCellsOpenedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesAroundCalculatedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleUnmarkedEvent;
use Micro\Game\Proxx\Domain\Factory\ValueObjectFactory;
use Micro\Game\Proxx\Domain\Factory\ValueObjectFactoryInterface;
use Micro\Game\Proxx\Domain\ValueObject\Cell;
use Micro\Game\Proxx\Domain\ValueObject\Cells;
use Micro\Game\Proxx\Domain\ValueObject\GameStatus;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
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
use Micro\Game\Proxx\Domain\Event\BlackHolesPlacedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellOpenedEvent;
use Micro\Game\Proxx\Domain\Event\CellsInstalledEvent;
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
     * ValueObjectFactory object.
     */
    protected ?ValueObjectFactoryInterface $valueObjectFactory;

    /**
     * process_uuid value object.
     */
    protected ?ProcessUuid $processUuid = null;

    /**
     * uuid value object.
     */
    protected ?Uuid $uuid = null;

    /**
     * Board cells.
     *
     * @var CellEntity[]
     */
    protected array $cells = [];

    /**
     * width value object.
     */
    protected Width $width;

    /**
     * number-of-black-holes value object.
     */
    protected NumberOfBlackHoles $numberOfBlackHoles;

    /**
     * number-of-opened-cells value object.
     */
    protected NumberOfOpenedCells $numberOfOpenedCells;

    /**
     * number-of-marked-black-holes value object.
     */
    protected NumberOfMarkedBlackHoles $numberOfMarkedBlackHoles;

    /**
     * status value object.
     */
    protected GameStatus $gameStatus;

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
    public function __construct(
        ?EventFactoryInterface $eventFactory = null,
        ?ValueObjectFactoryInterface $valueObjectFactory = null
    ) {
		$this->eventFactory = $eventFactory ?? new EventFactory();
        $this->valueObjectFactory = $valueObjectFactory ?? new ValueObjectFactory();
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
     * @return Cell[]
     */
    public function getCells(): array
    {
        return $this->cells;
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
		$this->apply($this->eventFactory->makeBoardCreatedEvent(
            $processUuid,
            $this->uuid,
            $board
        ));
    }

    /**
     * Apply BoardCreatedEvent event.
     */
    public function applyBoardCreatedEvent(BoardCreatedEvent $event): void
    {
        $this->processUuid = $event->getProcessUuid();
        $this->uuid = $event->getUuid();
        $this->assembleFromValueObject($event->getBoard());
    }

    /**
     * Execute set-cells command.
     */
    public function installCells(ProcessUuid $processUuid): void
    {
        $cells = [];
        $width = $this->width->toNative();

        for ($i = 0; $i < $width; ++$i) {
            $cells[$i] = [];

            for ($y = 0; $y < $this->width->toNative(); ++$y) {
                $cells[$i][$y] = $this->valueObjectFactory->makeCell(["position-x" => $i, "position-y" => $y]);
            }
        }
        $cells = $this->valueObjectFactory->makeCells($cells);
		$this->apply($this->eventFactory->makeCellsInstalledEvent($processUuid, $this->uuid, $cells));
    }

    /**
     * Apply CellsInstalledEvent event.
     */
    public function applyCellsInstalledEvent(CellsInstalledEvent $event): void
    {
        $cells = $event->getCells()->getItems();
        /** @var Cell $cellValueObject */
        foreach ($cells as $pos => $cellValueObject) {
            $this->cells[$pos] = CellEntity::createActual($cellValueObject);
        }
    }

    /**
     * Execute set-black-holes command.
     */
    public function setBlackHoles(ProcessUuid $processUuid): void
    {
        $boardWidth = $this->width->toNative();
        $numberOfBlackHoles = 0;
        $maxNumberOfBlackHoles = $this->numberOfBlackHoles->toNative();
        $min = 0;
        $max = $boardWidth - 1;
        $cells = [];

        while ($numberOfBlackHoles < $maxNumberOfBlackHoles) {
            //$randPositionX = stats_rand_gen_iuniform($min, $max);
            //$randPositionY = stats_rand_gen_iuniform($min, $max);
            $randPositionX = $this->getRandomCoordinate($min, $max, $numberOfBlackHoles);
            $randPositionY = mt_rand($min, $max);
            /* @var CellEntity $cell */
            $cell = $this->cells[Cells::generateKeyFromCoordinate($randPositionX, $randPositionY, $boardWidth)];

            if ($cell->hasBlackHole()) {
                continue;
            }
            $cell->setBlackHole();

            if (!isset($cells[$randPositionX])) {
                $cells[$randPositionX] = [];
            }
            $cells[$randPositionX][$randPositionY] = $cell->assembleToValueObject();
            ++$numberOfBlackHoles;
        }
        $cells = $this->valueObjectFactory->makeCells($cells);
		$this->apply($this->eventFactory->makeBlackHolesPlacedEvent($processUuid, $this->uuid, $cells));
    }

    protected function getRandomCoordinate(int $min, int $max, int $currentNumber): int
    {
        return ($currentNumber < ceil($max / 2)) ? mt_rand($min, mt_rand(1, mt_rand(1, $max))) : mt_rand(mt_rand($min, $max), $max);
    }

    /**
     * Apply BlackHolesPlacedEvent event.
     */
    public function applyBlackHolesPlacedEvent(BlackHolesPlacedEvent $event): void
    {
        $cells = $event->getCells()->getItems();

        foreach ($cells as $pos => $cellValueObject) {
            $this->cells[$pos]->setBlackHole();
        }
    }

    /**
     * Execute find-black-holes-around command.
     */
    public function calculateBlackHolesAround(ProcessUuid $processUuid): void
    {
        $cells = [];
        $width = $this->width->toNative();

        for ($x = 0; $x < $width; ++$x) {
            for ($y = 0; $y < $this->width->toNative(); ++$y) {
                $cell = $this->cells[Cells::generateKeyFromCoordinate($x, $y, $width)];

                if ($cell->hasBlackHole()) {
                    continue;
                }
                $numberOfBlackHolesAround = $this->calculateBlackHolesAroundCell($x, $y, $width);

                if ($numberOfBlackHolesAround === 0) {
                    continue;
                }
                $cell->setBlackHolesAround($this->valueObjectFactory->makeNumberOfBlackHolesAround($numberOfBlackHolesAround));

                if (!isset($cells[$x])) {
                    $cells[$x] = [];
                }
                $cells[$x][$y] = $cell;
            }
        }
        $cells = $this->valueObjectFactory->makeCells($cells);
		$this->apply($this->eventFactory->makeBlackHolesAroundCalculatedEvent($processUuid, $this->uuid, $cells));
    }

    protected function calculateBlackHolesAroundCell(int $positionX, int $positionY, int $boardWidth): int
    {
        $numberOfBlackHoles = 0;

		for ($deltaX = -1; $deltaX <= 1; ++$deltaX) {
            for ($deltaY = -1; $deltaY <= 1; ++$deltaY) {
                $assumedX = $positionX + $deltaX;
                $assumedY = $positionY + $deltaY;

                if ($assumedX < 0 || $assumedY < 0 || $assumedX === $boardWidth || $assumedY === $boardWidth) {
                    continue;
                }
                $neighborCell = $this->cells[Cells::generateKeyFromCoordinate($assumedX, $assumedY, $boardWidth)];

                if (!$neighborCell->hasBlackHole()) {
                    continue;
                }
                ++$numberOfBlackHoles;
            }
		}

        return $numberOfBlackHoles;
    }

    /**
     * Apply BlackHolesAroundCalculatedEvent event.
     */
    public function applyBlackHolesAroundCalculatedEvent(BlackHolesAroundCalculatedEvent $event): void
    {
        $cells = $event->getCells()->getItems();

        foreach ($cells as $pos => $cellValueObject) {
            $this->cells[$pos]->setBlackHolesAround($cellValueObject->getNumberOfBlackHolesAround());
        }
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
		$positionX = $event->getPositionX()->toNative();
		$positionY = $event->getPositionY()->toNative();
        $cell = $this->cells[Cells::generateKeyFromCoordinate($positionX, $positionY, $this->width->toNative())];
        $cell->open();
        $this->numberOfOpenedCells->inc();
    }

    /**
     * Execute mark-black-hole command.
     */
    public function markBlackHole(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY): void
    {
		$this->apply($this->eventFactory->makeBlackHoleMarkedEvent($processUuid, $this->uuid, $positionX, $positionY));
    }

    /**
     * Apply BlackHoleMarkedEvent event.
     */
    public function applyBlackHoleMarkedEvent(BlackHoleMarkedEvent $event): void
    {
        $positionX = $event->getPositionX()->toNative();
        $positionY = $event->getPositionY()->toNative();
        $cell = $this->cells[Cells::generateKeyFromCoordinate($positionX, $positionY, $this->width->toNative())];
        $cell->markBlackHole();
        $this->numberOfMarkedBlackHoles->inc();
    }

    /**
     * Execute unmark-black-hole command.
     */
    public function unmarkBlackHole(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY): void
    {
        $this->apply($this->eventFactory->makeBlackHoleUnmarkedEvent($processUuid, $this->uuid, $positionX, $positionY));
    }

    /**
     * Apply BlackHoleMarkedEvent event.
     */
    public function applyBlackHoleUnmarkedEvent(BlackHoleUnmarkedEvent $event): void
    {
        $positionX = $event->getPositionX()->toNative();
        $positionY = $event->getPositionY()->toNative();
        $cell = $this->cells[Cells::generateKeyFromCoordinate($positionX, $positionY, $this->width->toNative())];
        $cell->unmarkBlackHole();
        $this->numberOfMarkedBlackHoles->decr();
    }

    /**
     * Execute process-game command.
     */
    public function processGame(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY): void
    {
        $this->apply($this->eventFactory->makeGameProcessedEvent($processUuid, $this->uuid, $positionX, $positionY));
        $posX = $positionX->toNative();
        $posY = $positionY->toNative();
        $boardWidth = $this->width->toNative();
        $cell = $this->cells[Cells::generateKeyFromCoordinate($posX, $posY, $boardWidth)];

        if ($cell->isWasOpened() && $cell->hasBlackHole()) {
            $this->apply($this->eventFactory->makeGameUnsuccessfulFinishedEvent($processUuid, $this->uuid));

            return;
        }

        if ($this->numberOfOpenedCells->toNative() + $this->numberOfMarkedBlackHoles->toNative() === count($this->cells)) {
            $this->apply($this->eventFactory->makeGameSuccessfulFinishedEvent($processUuid, $this->uuid));

            return;
        }

        if (!$cell->hasBlackHolesAround()) {
            $openedCells = [];
            $this->openAroundCells($posX, $posY, $boardWidth, $openedCells);
            $cells = $this->valueObjectFactory->makeCells($openedCells);
            $this->apply($this->eventFactory->makeAroundCellsOpenedEvent($processUuid, $this->uuid, $cells));

            if ($this->numberOfOpenedCells->toNative() + $this->numberOfMarkedBlackHoles->toNative() === count($this->cells)) {
                $this->apply($this->eventFactory->makeGameSuccessfulFinishedEvent($processUuid, $this->uuid));
            }
        }
    }

    /**
     * Open around cells.
     */
    protected function openAroundCells(int $positionX, int $positionY, int $boardWidth, array &$openedCells): void
    {
        for ($deltaX = -1; $deltaX <= 1; ++$deltaX) {
            for ($deltaY = -1; $deltaY <= 1; ++$deltaY) {
                $assumedX = $positionX + $deltaX;
                $assumedY = $positionY + $deltaY;

                if ($assumedX < 0 || $assumedY < 0 || $assumedX > $boardWidth || $assumedY > $boardWidth) {
                    continue;
                }
                $neighborCell = $this->cells[Cells::generateKeyFromCoordinate($assumedX, $assumedY, $boardWidth)];

                if ($neighborCell->isWasOpened()) {
                    continue;
                }
                $neighborCell->open();

                if (!isset($openedCells[$assumedX])) {
                    $openedCells[$assumedX] = [];
                }
                $openedCells[$assumedX][$assumedY] = $neighborCell;

                if (!$neighborCell->hasBlackHolesAround()) {
                    $this->openAroundCells($assumedX, $assumedY, $boardWidth, $openedCells);
                }
            }
        }
    }

    /**
     * Apply AroundCellsOpenedEvent event.
     */
    public function applyAroundCellsOpenedEvent(AroundCellsOpenedEvent $event): void
    {
        $cells = $event->getCells()->getItems();

        foreach ($cells as $pos => $cellValueObject) {
            $this->cells[$pos]->open();
        }
    }

    /**
     * Factory method for creating a new BoardEntity.
     */
    public static function create(
        ProcessUuid $processUuid,
        Uuid $uuid,
        Board $board,
        ?Payload $payload = null,
        ?EventFactoryInterface $eventFactory = null,
        ?ValueObjectFactoryInterface $valueObjectFactory = null
    ): self {
		$entity = new static($eventFactory, $valueObjectFactory);
		$event = $entity->eventFactory->makeBoardCreatedEvent($processUuid, $uuid, $board);

		if ($payload !== null) {
			$event->setPayload($payload);
		}
		$entity->apply($event);

        return $entity;
    }

    /**
     * Factory method for creating a new BoardEntity.
     */
    public static function createActual(
        Uuid $uuid,
        Board $board,
        ?EventFactoryInterface $eventFactory = null,
        ?ValueObjectFactoryInterface $valueObjectFactory = null
    ): self {
		$entity = new static($eventFactory, $valueObjectFactory);
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

        if (null !== $valueObject->getGameStatus()) {
            $this->gameStatus = $valueObject->getGameStatus();
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

        if (null !== $this->getGameStatus()) {
            $data["game-status"] = $this->gameStatus->toNative();
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

    /**
     * Return game status.
     */
    public function getGameStatus(): GameStatus
    {
        return $this->gameStatus;
    }

    /**
     * Returns all child entities.
     *
     * Override this method if your aggregate root contains child entities.
     *
     * @return CellEntity[]
     */
    protected function getChildEntities(): array
    {
        return $this->cells;
    }
}
