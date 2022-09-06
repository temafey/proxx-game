<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Event\AroundBlackHolesFoundedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleMarkedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHoleSetedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesAroundSetedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesSetedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellOpenedEvent;
use Micro\Game\Proxx\Domain\Event\CellsSetedEvent;
use Micro\Game\Proxx\Domain\Event\OpenedEvent;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
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
    public function makeBoardCreatedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): BoardCreatedEvent
    {
        return new BoardCreatedEvent(
			$processUuid, $uuid, $positionX, $positionY, $payload
		);
    }

    /**
     * Create CellsSetedEvent Event.
     */
    public function makeCellsSetedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): CellsSetedEvent
    {
        return new CellsSetedEvent(
			$processUuid, $uuid, $board, $payload
		);
    }

    /**
     * Create BlackHolesSetedEvent Event.
     */
    public function makeBlackHolesSetedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): BlackHolesSetedEvent
    {
        return new BlackHolesSetedEvent(
			$processUuid, $uuid, $board, $payload
		);
    }

    /**
     * Create AroundBlackHolesFoundedEvent Event.
     */
    public function makeAroundBlackHolesFoundedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): AroundBlackHolesFoundedEvent
    {
        return new AroundBlackHolesFoundedEvent(
			$processUuid, $uuid, $board, $payload
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
     * Create CellCreatedEvent Event.
     */
    public function makeCellCreatedEvent(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): CellCreatedEvent
    {
        return new CellCreatedEvent(
			$processUuid, $positionX, $positionY, $payload
		);
    }

    /**
     * Create BlackHoleSetedEvent Event.
     */
    public function makeBlackHoleSetedEvent(ProcessUuid $processUuid, ?Payload $payload = null): BlackHoleSetedEvent
    {
        return new BlackHoleSetedEvent(
			$processUuid, $payload
		);
    }

    /**
     * Create OpenedEvent Event.
     */
    public function makeOpenedEvent(ProcessUuid $processUuid, ?Payload $payload = null): OpenedEvent
    {
        return new OpenedEvent(
			$processUuid, $payload
		);
    }

    /**
     * Create BlackHolesAroundSetedEvent Event.
     */
    public function makeBlackHolesAroundSetedEvent(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround, ?Payload $payload = null): BlackHolesAroundSetedEvent
    {
        return new BlackHolesAroundSetedEvent(
			$processUuid, $numberOfBlackHolesAround, $payload
		);
    }

    /**
     * Create BlackHoleMarkedEvent Event.
     */
    public function makeBlackHoleMarkedEvent(ProcessUuid $processUuid, ?Payload $payload = null): BlackHoleMarkedEvent
    {
        return new BlackHoleMarkedEvent(
			$processUuid, $payload
		);
    }
}
