<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;

/**
 * @class GameProcessedEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class GameProcessedEvent extends CellOpenedEvent
{}
