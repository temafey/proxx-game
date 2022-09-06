<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\Saga;

use Broadway\Saga\Metadata\StaticallyConfiguredSagaInterface;
use Broadway\Saga\State;
use League\Tactician\CommandBus;
use Micro\Game\Proxx\Domain\Factory\CommandFactoryInterface;
use MicroModule\Saga\AbstractSaga;
use Micro\Game\Proxx\Domain\Event\AroundBlackHolesFoundedEvent;
use Micro\Game\Proxx\Domain\Event\BlackHolesSetedEvent;
use Micro\Game\Proxx\Domain\Event\BoardCreatedEvent;
use Micro\Game\Proxx\Domain\Event\CellsSetedEvent;

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
			'CellsSetedEvent' => static function(CellsSetedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'BlackHolesSetedEvent' => static function(BlackHolesSetedEvent $event) {
				return new State\Criteria([self::STATE_CRITERIA_KEY => $event->getProcessUuid()->toNative()]);
			},
			'AroundBlackHolesFoundedEvent' => static function(AroundBlackHolesFoundedEvent $event) {
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
		$state->setDone();

        return $state;
    }

    /**
     * Handle CellsSetedEvent event.
     */
    public function handleCellsSetedEvent(State $state, CellsSetedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$state->setDone();

        return $state;
    }

    /**
     * Handle BlackHolesSetedEvent event.
     */
    public function handleBlackHolesSetedEvent(State $state, BlackHolesSetedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$state->setDone();

        return $state;
    }

    /**
     * Handle AroundBlackHolesFoundedEvent event.
     */
    public function handleAroundBlackHolesFoundedEvent(State $state, AroundBlackHolesFoundedEvent $event): State
    {
		$state->set(self::STATE_CRITERIA_KEY, (string) $event->getProcessUuid());
		$state->setDone();

        return $state;
    }
}
