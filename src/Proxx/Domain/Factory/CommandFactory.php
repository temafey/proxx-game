<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Base\Domain\Command\CommandInterface as BaseCommandInterface;
use MicroModule\Base\Domain\Exception\FactoryException;
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
use Micro\Game\Proxx\Domain\ValueObject\Board;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;

/**
 * @class CommandFactory
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
class CommandFactory implements CommandFactoryInterface
{
    protected const ALLOWED_COMMANDS = [
        self::CREATE_BOARD_COMMAND,
		self::SET_CELLS_COMMAND,
		self::SET_BLACK_HOLES_COMMAND,
		self::FIND_BLACK_HOLES_AROUND_COMMAND,
		self::OPEN_CELL_COMMAND,
		self::MARK_BLACK_HOLE_ON_CELL_COMMAND,
		self::CREATE_CELL_COMMAND,
		self::SET_BLACK_HOLE_COMMAND,
		self::OPEN_COMMAND,
		self::SET_BLACK_HOLES_AROUND_COMMAND,
		self::MARK_BLACK_HOLE_COMMAND,
    ];

    public function isCommandAllowed(string $commandType): bool
    {
        return in_array($commandType, static::ALLOWED_COMMANDS);
    }

    /**
     * Make command by command constant.
     *
     * @throws FactoryException
     */
    public function makeCommandInstanceByType(...$args): BaseCommandInterface
    {
        $type = (string)array_shift($args);

        return match ($type) {
            self::CREATE_BOARD_COMMAND => $this->makeCreateBoardCommand(...$args),
			self::SET_CELLS_COMMAND => $this->makeSetCellsCommand(...$args),
			self::SET_BLACK_HOLES_COMMAND => $this->makeSetBlackHolesCommand(...$args),
			self::FIND_BLACK_HOLES_AROUND_COMMAND => $this->makeFindBlackHolesAroundCommand(...$args),
			self::OPEN_CELL_COMMAND => $this->makeOpenCellCommand(...$args),
			self::MARK_BLACK_HOLE_ON_CELL_COMMAND => $this->makeMarkBlackHoleOnCellCommand(...$args),
			self::CREATE_CELL_COMMAND => $this->makeCreateCellCommand(...$args),
			self::SET_BLACK_HOLE_COMMAND => $this->makeSetBlackHoleCommand(...$args),
			self::OPEN_COMMAND => $this->makeOpenCommand(...$args),
			self::SET_BLACK_HOLES_AROUND_COMMAND => $this->makeSetBlackHolesAroundCommand(...$args),
			self::MARK_BLACK_HOLE_COMMAND => $this->makeMarkBlackHoleCommand(...$args),
            default => throw new FactoryException(sprintf('Command for type `%s` not found!', $type)),
        };
    }

    /**
     * Create CreateBoardCommand Command.
     */
    public function makeCreateBoardCommand(string $processUuid, string $uuid, array $board): CreateBoardCommand
    {
        return new CreateBoardCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid), 
			Board::fromNative($board)
		);
    }

    /**
     * Create SetCellsCommand Command.
     */
    public function makeSetCellsCommand(string $processUuid, string $uuid): SetCellsCommand
    {
        return new SetCellsCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid)
		);
    }

    /**
     * Create SetBlackHolesCommand Command.
     */
    public function makeSetBlackHolesCommand(string $processUuid, string $uuid): SetBlackHolesCommand
    {
        return new SetBlackHolesCommand(
			ProcessUuid::fromNative($processUuid), 
			Uuid::fromNative($uuid)
		);
    }

    /**
     * Create FindBlackHolesAroundCommand Command.
     */
    public function makeFindBlackHolesAroundCommand(string $processUuid, string $uuid): FindBlackHolesAroundCommand
    {
        return new FindBlackHolesAroundCommand(
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
     * Create CreateCellCommand Command.
     */
    public function makeCreateCellCommand(string $processUuid, int $positionX, int $positionY): CreateCellCommand
    {
        return new CreateCellCommand(
			ProcessUuid::fromNative($processUuid), 
			PositionX::fromNative($positionX), 
			PositionY::fromNative($positionY)
		);
    }

    /**
     * Create SetBlackHoleCommand Command.
     */
    public function makeSetBlackHoleCommand(string $processUuid): SetBlackHoleCommand
    {
        return new SetBlackHoleCommand(
			ProcessUuid::fromNative($processUuid)
		);
    }

    /**
     * Create OpenCommand Command.
     */
    public function makeOpenCommand(string $processUuid): OpenCommand
    {
        return new OpenCommand(
			ProcessUuid::fromNative($processUuid)
		);
    }

    /**
     * Create SetBlackHolesAroundCommand Command.
     */
    public function makeSetBlackHolesAroundCommand(string $processUuid, int $numberOfBlackHolesAround): SetBlackHolesAroundCommand
    {
        return new SetBlackHolesAroundCommand(
			ProcessUuid::fromNative($processUuid), 
			NumberOfBlackHolesAround::fromNative($numberOfBlackHolesAround)
		);
    }

    /**
     * Create MarkBlackHoleCommand Command.
     */
    public function makeMarkBlackHoleCommand(string $processUuid): MarkBlackHoleCommand
    {
        return new MarkBlackHoleCommand(
			ProcessUuid::fromNative($processUuid)
		);
    }

}
