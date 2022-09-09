<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\Command\UnmarkBlackHoleOnCellCommand;
use MicroModule\Base\Domain\Command\CommandInterface as BaseCommandInterface;
use MicroModule\Base\Domain\Exception\FactoryException;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Command\CalculateBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Command\CreateBoardCommand;
use Micro\Game\Proxx\Domain\Command\InstallCellsCommand;
use Micro\Game\Proxx\Domain\Command\MarkBlackHoleOnCellCommand;
use Micro\Game\Proxx\Domain\Command\OpenCellCommand;
use Micro\Game\Proxx\Domain\Command\PlaceBlackHolesCommand;
use Micro\Game\Proxx\Domain\Command\ProcessGameCommand;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @class CommandFactory
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
class CommandFactory implements CommandFactoryInterface
{
    protected const ALLOWED_COMMANDS = [
        self::CREATE_BOARD_COMMAND,
		self::INSTALL_CELLS_COMMAND,
		self::PLACE_BLACK_HOLES_COMMAND,
		self::CALCULATE_BLACK_HOLES_AROUND_COMMAND,
		self::OPEN_CELL_COMMAND,
		self::MARK_BLACK_HOLE_ON_CELL_COMMAND,
		self::PROCESS_GAME_COMMAND,
		self::SET_BLACK_HOLES_AROUND_COMMAND,
		self::MARK_BLACK_HOLE_COMMAND,
        self::UNMARK_BLACK_HOLE_COMMAND,
    ];

    public function isCommandAllowed(string $commandType): bool
    {
        return in_array($commandType, static::ALLOWED_COMMANDS);
    }

    /**
     * Make command by command constant.
     *
     * @throws FactoryException
     * @throws Exception
     */
    public function makeCommandInstanceByType(...$args): BaseCommandInterface
    {
        $type = (string)array_shift($args);
        if ($type === self::PROCESS_GAME_COMMAND) {
            $test = 1;
        }

        return match ($type) {
            self::CREATE_BOARD_COMMAND => $this->makeCreateBoardCommand(...$args),
			self::INSTALL_CELLS_COMMAND => $this->makeInstallCellsCommand(...$args),
			self::PLACE_BLACK_HOLES_COMMAND => $this->makePlaceBlackHolesCommand(...$args),
			self::CALCULATE_BLACK_HOLES_AROUND_COMMAND => $this->makeCalculateBlackHolesAroundCommand(...$args),
			self::OPEN_CELL_COMMAND => $this->makeOpenCellCommand(...$args),
			self::MARK_BLACK_HOLE_ON_CELL_COMMAND => $this->makeMarkBlackHoleOnCellCommand(...$args),
			self::PROCESS_GAME_COMMAND => $this->makeProcessGameCommand(...$args),
			self::SET_BLACK_HOLES_AROUND_COMMAND => $this->makeSetBlackHolesAroundCommand(...$args),
			self::MARK_BLACK_HOLE_COMMAND => $this->makeMarkBlackHoleCommand(...$args), 
			self::UNMARK_BLACK_HOLE_COMMAND => $this->makeUnmarkBlackHoleCommand(...$args),
            default => throw new FactoryException(sprintf('Command for type `%s` not found!', $type)),
        };
    }

    /**
     * Create CreateBoardCommand Command.
     */
    public function makeCreateBoardCommand(string $processUuid, string $uuid, int $width, int $numberOfBlackHoles): CreateBoardCommand
    {
        return new CreateBoardCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid), 
			Width::fromNative($width), 
			NumberOfBlackHoles::fromNative($numberOfBlackHoles)
		);
    }

    /**
     * Create InstallCellsCommand Command.
     */
    public function makeInstallCellsCommand(string $processUuid, string $uuid): InstallCellsCommand
    {
        return new InstallCellsCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid)
		);
    }

    /**
     * Create PlaceBlackHolesCommand Command.
     */
    public function makePlaceBlackHolesCommand(string $processUuid, string $uuid): PlaceBlackHolesCommand
    {
        return new PlaceBlackHolesCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid)
		);
    }

    /**
     * Create CalculateBlackHolesAroundCommand Command.
     */
    public function makeCalculateBlackHolesAroundCommand(string $processUuid, string $uuid): CalculateBlackHolesAroundCommand
    {
        return new CalculateBlackHolesAroundCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid)
		);
    }

    /**
     * Create OpenCellCommand Command.
     */
    public function makeOpenCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): OpenCellCommand
    {
        return new OpenCellCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid), 
			PositionX::fromNative($positionX), 
			PositionY::fromNative($positionY)
		);
    }

    /**
     * Create MarkBlackHoleOnCellCommand Command.
     */
    public function makeMarkBlackHoleOnCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): MarkBlackHoleOnCellCommand
    {
        return new MarkBlackHoleOnCellCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid), 
			PositionX::fromNative($positionX), 
			PositionY::fromNative($positionY)
		);
    }

    /**
     * Create makeUnmarkBlackHoleOnCellCommand Command.
     */
    public function makeUnmarkBlackHoleOnCellCommand(string $processUuid, string $uuid, int $positionX, int $positionY): UnmarkBlackHoleOnCellCommand
    {
        return new UnmarkBlackHoleOnCellCommand(
            ProcessUuid::fromNative($processUuid),
            Uuid::fromNative($uuid),
            PositionX::fromNative($positionX),
            PositionY::fromNative($positionY)
        );
    }

    /**
     * Create ProcessGameCommand Command.
     */
    public function makeProcessGameCommand(string $processUuid, string $uuid, int $positionX, int $positionY): ProcessGameCommand
    {
        return new ProcessGameCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid),
            PositionX::fromNative($positionX),
            PositionY::fromNative($positionY)
		);
    }

}
