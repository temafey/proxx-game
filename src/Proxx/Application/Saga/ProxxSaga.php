<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\Saga;

use Broadway\Saga\Metadata\StaticallyConfiguredSagaInterface;
use Broadway\Saga\State;
use League\Tactician\CommandBus;
use MicroModule\Saga\AbstractSaga;
use Micro\Game\Proxx\Domain\Factory\CommandFactoryInterface;
use Micro\Game\Proxx\Domain\Event\BlackHoleMarkedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesAroundCalculatedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesPlacedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellOpenedEvent;
use Micro\Game\Proxx\Domain\Event\CellsInstalledEvent;
use Micro\Game\Proxx\Domain\Event\GameSuccessfulFinishedEvent;
use Micro\Game\Proxx\Domain\Event\GameUnsuccessfulFinishedEvent;

/**
 * @class ProxxSaga
 *
 * @package Micro\Game\Proxx\Application\Saga
 */
class ProxxSaga extends AbstractSaga implements StaticallyConfiguredSagaInterface
{
    protected const STATE_CRITERIA_KEY = 'processId';

    protected CommandBus $commandBus;

    protected CommandFactoryInterface $commandFactory;

    /**
     * Constructor
     */
    public function __construct(CommandBus $commandBus, CommandFactoryInterface $commandFactory)
    {
		$this->commandBus = $commandBus;
		$this->commandFactory = $commandFactory;
    }

    /**
     * Saga configuration method, return map of events and state search criteria.
     */
    public static function configuration()
    {
        return [
			'BoardCreatedEvent' => static function(BoardCreatedEvent $event) {
				return null; // no criteria, start of a new saga
			},
			'CellsInstalledEvent' => static function(CellsInstalledEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'BlackHolesPlacedEvent' => static function(BlackHolesPlacedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'CellOpenedEvent' => static function(CellOpenedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'BlackHoleMarkedEvent' => static function(BlackHoleMarkedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'GameSuccessfulFinishedEvent' => static function(GameSuccessfulFinishedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'GameUnsuccessfulFinishedEvent' => static function(GameUnsuccessfulFinishedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			}
		];
    }

    /**
     * Handle BoardCreatedEvent event.
     */
    public function handleBoardCreatedEvent(State $state, BoardCreatedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::INSTALL_CELLS_COMMAND, 
			$event->getProcessUuid()->toNative(),
			$event->getUuid()->toNative()
		);
		$this->commandBus->handle($command);

        return $state;
    }

    /**
     * Handle CellsInstalledEvent event.
     */
    public function handleCellsInstalledEvent(State $state, CellsInstalledEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::PLACE_BLACK_HOLES_COMMAND, 
			$event->getProcessUuid()->toNative(),
			$event->getUuid()->toNative()
		);
		$this->commandBus->handle($command);

        return $state;
    }

    /**
     * Handle BlackHolesPlacedEvent event.
     */
    public function handleBlackHolesPlacedEvent(State $state, BlackHolesPlacedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::CALCULATE_BLACK_HOLES_AROUND_COMMAND, 
			$event->getProcessUuid()->toNative(),
			$event->getUuid()->toNative()
		);
		$this->commandBus->handle($command);

        return $state;
    }

    /**
     * Handle CellOpenedEvent event.
     */
    public function handleCellOpenedEvent(State $state, CellOpenedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::PROCESS_GAME_COMMAND, 
			$event->getProcessUuid()->toNative(),
			$event->getUuid()->toNative(),
            $event->getPositionX()->toNative(),
            $event->getPositionY()->toNative(),
		);
		$this->commandBus->handle($command);

        return $state;
    }

    /**
     * Handle BlackHoleMarkedEvent event.
     */
    public function handleBlackHoleMarkedEvent(State $state, BlackHoleMarkedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::PROCESS_GAME_COMMAND, 
			$event->getProcessUuid()->toNative(),
			$event->getUuid()->toNative(),
            $event->getPositionX()->toNative(),
            $event->getPositionY()->toNative(),
		);
		$this->commandBus->handle($command);

        return $state;
    }

    /**
     * Handle GameSuccessfulFinishedEvent event.
     */
    public function handleGameSuccessfulFinishedEvent(State $state, GameSuccessfulFinishedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$state->setDone();

        return $state;
    }

    /**
     * Handle GameUnsuccessfulFinishedEvent event.
     */
    public function handleGameUnsuccessfulFinishedEvent(State $state, GameUnsuccessfulFinishedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$state->setDone();

        return $state;
    }
}
