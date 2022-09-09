<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\Event\AroundCellsOpenedEvent;
use MicroModule\Common\Domain\ValueObject\Id;
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
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\Proxx;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @interface EventFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface EventFactoryInterface
{
    /**
     * Create BoardCreatedEvent Event.
     */
    public function makeBoardCreatedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): BoardCreatedEvent;

    /**
     * Create CellsInstalledEvent Event.
     */
    public function makeCellsInstalledEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): CellsInstalledEvent;

    /**
     * Create BlackHolesPlacedEvent Event.
     */
    public function makeBlackHolesPlacedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): BlackHolesPlacedEvent;

    /**
     * Create BlackHolesAroundCalculatedEvent Event.
     */
    public function makeBlackHolesAroundCalculatedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): BlackHolesAroundCalculatedEvent;

    /**
     * Create CellOpenedEvent Event.
     */
    public function makeCellOpenedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): CellOpenedEvent;

    /**
     * Create BlackHoleMarkedEvent Event.
     */
    public function makeBlackHoleMarkedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): BlackHoleMarkedEvent;

    /**
     * Create GameProcessedEvent Event.
     */
    public function makeGameProcessedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): GameProcessedEvent;

    /**
     * Create GameSuccessfulFinishedEvent Event.
     */
    public function makeGameSuccessfulFinishedEvent(ProcessUuid $processUuid, Uuid $uuid, ?Payload $payload = null): GameSuccessfulFinishedEvent;

    /**
     * Create GameUnsuccessfulFinishedEvent Event.
     */
    public function makeGameUnsuccessfulFinishedEvent(ProcessUuid $processUuid, Uuid $uuid, ?Payload $payload = null): GameUnsuccessfulFinishedEvent;

    /**
     * Create AroundCellsOpenedEvent Event.
     */
    public function makeAroundCellsOpenedEvent(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null): AroundCellsOpenedEvent;
}
