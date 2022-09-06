<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Common\Domain\Factory\CommandFactoryInterface as BaseCommandFactoryInterface;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Command\CreateBoardCommand;
use Micro\Game\Proxx\Domain\Command\CreateCellCommand;
use Micro\Game\Proxx\Domain\Command\FindBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Command\MarkBlackHoleCommand;
use Micro\Game\Proxx\Domain\Command\MarkBlackHoleOnCellCommand;
use Micro\Game\Proxx\Domain\Command\OpenCellCommand;
use Micro\Game\Proxx\Domain\Command\OpenCommand;
use Micro\Game\Proxx\Domain\Command\SetBlackHoleCommand;
use Micro\Game\Proxx\Domain\Command\SetBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Command\SetBlackHolesCommand;
use Micro\Game\Proxx\Domain\Command\SetCellsCommand;
use Micro\Game\Proxx\Domain\Command\Task\CreateBoardTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\CreateCellTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\FindBlackHolesAroundTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\MarkBlackHoleOnCellTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\MarkBlackHoleTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\OpenCellTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\OpenTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\SetBlackHoleTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\SetBlackHolesAroundTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\SetBlackHolesTaskCommand;
use Micro\Game\Proxx\Domain\Command\Task\SetCellsTaskCommand;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\Proxx;

/**
 * @interface CommandFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface CommandFactoryInterface extends BaseCommandFactoryInterface
{
	public const CREATE_BOARD_COMMAND = "CreateBoardCommand";
	public const SET_CELLS_COMMAND = "SetCellsCommand";
	public const SET_BLACK_HOLES_COMMAND = "SetBlackHolesCommand";
	public const FIND_BLACK_HOLES_AROUND_COMMAND = "FindBlackHolesAroundCommand";
	public const OPEN_CELL_COMMAND = "OpenCellCommand";
	public const MARK_BLACK_HOLE_ON_CELL_COMMAND = "MarkBlackHoleOnCellCommand";
	public const CREATE_CELL_COMMAND = "CreateCellCommand";
	public const SET_BLACK_HOLE_COMMAND = "SetBlackHoleCommand";
	public const OPEN_COMMAND = "OpenCommand";
	public const SET_BLACK_HOLES_AROUND_COMMAND = "SetBlackHolesAroundCommand";
	public const MARK_BLACK_HOLE_COMMAND = "MarkBlackHoleCommand";

    /**
     * Create CreateBoardCommand Command.
     */
    public function makeCreateBoardCommand(string $processUuid, string $uuid, array $board): CreateBoardCommand;

    /**
     * Create SetCellsCommand Command.
     */
    public function makeSetCellsCommand(string $processUuid, string $uuid): SetCellsCommand;

    /**
     * Create SetBlackHolesCommand Command.
     */
    public function makeSetBlackHolesCommand(string $processUuid, string $uuid): SetBlackHolesCommand;

    /**
     * Create FindBlackHolesAroundCommand Command.
     */
    public function makeFindBlackHolesAroundCommand(string $processUuid, string $uuid): FindBlackHolesAroundCommand;

    /**
     * Create OpenCellCommand Command.
     */
    public function makeOpenCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): OpenCellCommand;

    /**
     * Create MarkBlackHoleOnCellCommand Command.
     */
    public function makeMarkBlackHoleOnCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): MarkBlackHoleOnCellCommand;

    /**
     * Create CreateCellCommand Command.
     */
    public function makeCreateCellCommand(string $processUuid, int $positionX, int $positionY): CreateCellCommand;

    /**
     * Create SetBlackHoleCommand Command.
     */
    public function makeSetBlackHoleCommand(string $processUuid): SetBlackHoleCommand;

    /**
     * Create OpenCommand Command.
     */
    public function makeOpenCommand(string $processUuid): OpenCommand;

    /**
     * Create SetBlackHolesAroundCommand Command.
     */
    public function makeSetBlackHolesAroundCommand(string $processUuid, int $numberOfBlackHolesAround): SetBlackHolesAroundCommand;

    /**
     * Create MarkBlackHoleCommand Command.
     */
    public function makeMarkBlackHoleCommand(string $processUuid): MarkBlackHoleCommand;
}
