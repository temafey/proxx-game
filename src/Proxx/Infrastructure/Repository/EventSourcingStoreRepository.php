<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Infrastructure\Repository;

use Broadway\EventHandling\EventBus as EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventSourcing\EventStreamDecorator as EventStreamDecoratorInterface;
use Broadway\EventStore\EventStore as EventStoreInterface;
use Micro\Game\Proxx\Domain\Entity\BoardEntity;

/**
 * @class EventSourcingStoreRepository
 *
 * @package Micro\Game\Proxx\Infrastructure\Repository
 */
class EventSourcingStoreRepository extends EventSourcingRepository
{
    /**
     * @param EventStreamDecoratorInterface[] $eventStreamDecorators
     */
    public function __construct(
        EventStoreInterface $eventStore,
        EventBusInterface $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            BoardEntity::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}
