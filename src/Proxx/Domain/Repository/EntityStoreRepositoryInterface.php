<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Repository;

use InvalidArgumentException;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepository;
use MicroModule\Snapshotting\EventSourcing\SnapshottingEventSourcingRepositoryException;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * @interface EntityStoreRepositoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Repository
 */
interface EntityStoreRepositoryInterface
{
   /**
     * Retrieve ProxxEntity with applied events
     */
    public function get(UuidInterface $uuid): BoardEntityInterface;

    /**
     * Save ProxxEntity last uncommitted events
     *
     * @throws SnapshottingEventSourcingRepositoryException
     */
    public function store(BoardEntityInterface $entity): void;
}
