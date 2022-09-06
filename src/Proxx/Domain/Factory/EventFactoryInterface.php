<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Common\Domain\ValueObject\Id;
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
 * @interface EventFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface EventFactoryInterface
{
    /**
     * Create BoardCreatedEvent Event.
     */
    public function makeBoardCreatedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): BoardCreatedEvent;

    /**
     * Create CellsSetedEvent Event.
     */
    public function makeCellsSetedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): CellsSetedEvent;

    /**
     * Create BlackHolesSetedEvent Event.
     */
    public function makeBlackHolesSetedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): BlackHolesSetedEvent;

    /**
     * Create AroundBlackHolesFoundedEvent Event.
     */
    public function makeAroundBlackHolesFoundedEvent(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null): AroundBlackHolesFoundedEvent;

    /**
     * Create CellOpenedEvent Event.
     */
    public function makeCellOpenedEvent(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): CellOpenedEvent;

    /**
     * Create CellCreatedEvent Event.
     */
    public function makeCellCreatedEvent(ProcessUuid $processUuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null): CellCreatedEvent;

    /**
     * Create BlackHoleSetedEvent Event.
     */
    public function makeBlackHoleSetedEvent(ProcessUuid $processUuid, ?Payload $payload = null): BlackHoleSetedEvent;

    /**
     * Create OpenedEvent Event.
     */
    public function makeOpenedEvent(ProcessUuid $processUuid, ?Payload $payload = null): OpenedEvent;

    /**
     * Create BlackHolesAroundSetedEvent Event.
     */
    public function makeBlackHolesAroundSetedEvent(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround, ?Payload $payload = null): BlackHolesAroundSetedEvent;

    /**
     * Create BlackHoleMarkedEvent Event.
     */
    public function makeBlackHoleMarkedEvent(ProcessUuid $processUuid, ?Payload $payload = null): BlackHoleMarkedEvent;
}
