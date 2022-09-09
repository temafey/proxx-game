<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Infrastructure\Repository;

use InvalidArgumentException;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepository;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepositoryException;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * @class EntityStoreRepository
 *
 * @package Micro\Game\Proxx\Infrastructure\Repository
 */
class EntityStoreRepository extends SnapshottingEventSourcingRepository implements EntityStoreRepositoryInterface
{

   /**
     * Retrieve BoardEntity with applied events.
     */
    public function get(UuidInterface $uuid): BoardEntityInterface
    {
        $entity = $this->load($uuid->toString());
        
        if (!$entity instanceof BoardEntityInterface) {
            throw new InvalidArgumentException('Return object should implement BoardEntity.');
        }

        return $entity;
    }

    /**
     * Save BoardEntity last uncommitted events.
     *
     * @throws SnapshottingEventSourcingRepositoryException
     */
    public function store(BoardEntityInterface $entity): void
    {
        $this->save($entity);
    }
}
