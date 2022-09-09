<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use MicroModule\Common\Domain\ValueObject\Uuid;

/**
 * @class BlackHolesAroundCalculatedEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class BlackHolesAroundCalculatedEvent extends CellsInstalledEvent
{
}
