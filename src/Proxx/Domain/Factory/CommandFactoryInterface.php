<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\Command\UnmarkBlackHoleOnCellCommand;
use MicroModule\Common\Domain\Factory\CommandFactoryInterface as BaseCommandFactoryInterface;
use Micro\Game\Proxx\Domain\Command\CalculateBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Command\CreateBoardCommand;
use Micro\Game\Proxx\Domain\Command\InstallCellsCommand;
use Micro\Game\Proxx\Domain\Command\MarkBlackHoleOnCellCommand;
use Micro\Game\Proxx\Domain\Command\OpenCellCommand;
use Micro\Game\Proxx\Domain\Command\PlaceBlackHolesCommand;
use Micro\Game\Proxx\Domain\Command\ProcessGameCommand;

/**
 * @interface CommandFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface CommandFactoryInterface extends BaseCommandFactoryInterface
{
	public const CREATE_BOARD_COMMAND = "CreateBoardCommand";
	public const INSTALL_CELLS_COMMAND = "InstallCellsCommand";
	public const PLACE_BLACK_HOLES_COMMAND = "PlaceBlackHolesCommand";
	public const CALCULATE_BLACK_HOLES_AROUND_COMMAND = "CalculateBlackHolesAroundCommand";
	public const OPEN_CELL_COMMAND = "OpenCellCommand";
	public const MARK_BLACK_HOLE_ON_CELL_COMMAND = "MarkBlackHoleOnCellCommand";
    public const UNMARK_BLACK_HOLE_COMMAND = "UnmarkBlackHoleCommand";
	public const PROCESS_GAME_COMMAND = "ProcessGameCommand";
	public const SET_BLACK_HOLES_AROUND_COMMAND = "SetBlackHolesAroundCommand";
	public const MARK_BLACK_HOLE_COMMAND = "MarkBlackHoleCommand";

    /**
     * Create CreateBoardCommand Command.
     */
    public function makeCreateBoardCommand(string $processUuid, string $uuid, int $width, int $numberOfBlackHoles): CreateBoardCommand;

    /**
     * Create InstallCellsCommand Command.
     */
    public function makeInstallCellsCommand(string $processUuid, string $uuid): InstallCellsCommand;

    /**
     * Create PlaceBlackHolesCommand Command.
     */
    public function makePlaceBlackHolesCommand(string $processUuid, string $uuid): PlaceBlackHolesCommand;

    /**
     * Create CalculateBlackHolesAroundCommand Command.
     */
    public function makeCalculateBlackHolesAroundCommand(string $processUuid, string $uuid): CalculateBlackHolesAroundCommand;

    /**
     * Create OpenCellCommand Command.
     */
    public function makeOpenCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): OpenCellCommand;

    /**
     * Create MarkBlackHoleOnCellCommand Command.
     */
    public function makeMarkBlackHoleOnCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): MarkBlackHoleOnCellCommand;

    /**
     * Create UnmarkBlackHoleOnCellCommand Command.
     */
    public function makeUnmarkBlackHoleOnCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): UnmarkBlackHoleOnCellCommand;

    /**
     * Create ProcessGameCommand Command.
     */
    public function makeProcessGameCommand(string $processUuid, string $uuid, int $positionX, int $positionY): ProcessGameCommand;

}
