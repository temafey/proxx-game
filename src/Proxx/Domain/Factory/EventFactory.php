<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\Event\AroundCellsOpenedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleUnmarkedEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Event\BlackHoleMarkedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesAroundCalculatedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesPlacedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellOpenedEvent;
use Micro\Game\Proxx\Domain\Event\CellsInstalledEvent;
use Micro\Game\Proxx\Domain\Event\GameProcessedEvent;
use Micro\Game\Proxx\Domain\Event\GameSuccessfulFinishedEvent;
use Micro\Game\Proxx\Domain\Event\GameUnsuccessfulFinishedEvent;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\Cells;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\Proxx;

/**
 * @class EventFactory
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
class EventFactory implements EventFactoryInterface
{
    /**
     * Create BoardCreatedEvent Event.
     */
    public function makeBoardCreatedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): BoardCreatedEvent
    {
        return new BoardCreatedEvent(
			$processUuid, $uuid, $board, $payload
		);
    }

    /**
     * Create CellsInstalledEvent Event.
     */
    public function makeCellsInstalledEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): CellsInstalledEvent
    {
        return new CellsInstalledEvent(
			$processUuid, $uuid, $cells, $payload
		);
    }

    /**
     * Create BlackHolesPlacedEvent Event.
     */
    public function makeBlackHolesPlacedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): BlackHolesPlacedEvent
    {
        return new BlackHolesPlacedEvent(
			$processUuid, $uuid, $cells, $payload
		);
    }

    /**
     * Create BlackHolesAroundCalculatedEvent Event.
     */
    public function makeBlackHolesAroundCalculatedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): BlackHolesAroundCalculatedEvent
    {
        return new BlackHolesAroundCalculatedEvent(
			$processUuid, $uuid, $cells, $payload
		);
    }

    /**
     * Create CellOpenedEvent Event.
     */
    public function makeCellOpenedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): CellOpenedEvent
    {
        return new CellOpenedEvent(
			$processUuid, $uuid, $positionX, $positionY, $payload
		);
    }

    /**
     * Create BlackHoleMarkedEvent Event.
     */
    public function makeBlackHoleMarkedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): BlackHoleMarkedEvent
    {
        return new BlackHoleMarkedEvent(
			$processUuid, $uuid, $positionX, $positionY, $payload
		);
    }

    /**
     * Create BlackHoleUnmarkedEvent Event.
     */
    public function makeBlackHoleUnmarkedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): BlackHoleMarkedEvent
    {
        return new BlackHoleUnmarkedEvent(
            $processUuid, $uuid, $positionX, $positionY, $payload
        );
    }

    /**
     * Create GameProcessedEvent Event.
     */
    public function makeGameProcessedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): GameProcessedEvent
    {
        return new GameProcessedEvent(
            $processUuid, $uuid, $positionX, $positionY, $payload
        );
    }

    /**
     * Create GameSuccessfulFinishedEvent Event.
     */
    public function makeGameSuccessfulFinishedEvent(ProcessUuid $processUuid, Uuid $uuid, ?Payload $payload = null): GameSuccessfulFinishedEvent
    {
        return new GameSuccessfulFinishedEvent(
			$processUuid, $uuid, $payload
		);
    }

    /**
     * Create GameUnsuccessfulFinishedEvent Event.
     */
    public function makeGameUnsuccessfulFinishedEvent(ProcessUuid $processUuid, Uuid $uuid, ?Payload $payload = null): GameUnsuccessfulFinishedEvent
    {
        return new GameUnsuccessfulFinishedEvent(
			$processUuid, $uuid, $payload
		);
    }

    /**
     * Create AroundCellsOpenedEvent Event.
     */
    public function makeAroundCellsOpenedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): AroundCellsOpenedEvent
    {
        return new AroundCellsOpenedEvent(
            $processUuid, $uuid, $cells, $payload
        );
    }
}
