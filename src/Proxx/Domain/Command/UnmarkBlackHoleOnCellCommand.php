<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Command;

use MicroModule\Common\Domain\Command\AbstractCommand;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;

/**
 * @class UnmarkBlackHoleOnCellCommand
 *
 * @package Micro\Game\Proxx\Domain\Command
 */
class UnmarkBlackHoleOnCellCommand extends OpenCellCommand
{
}
