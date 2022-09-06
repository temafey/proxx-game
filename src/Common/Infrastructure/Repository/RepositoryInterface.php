<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Repository;

use MicroModule\Common\Domain\Entity\EntityInterface;
use MicroModule\Common\Domain\ValueObject\Uuid;

interface RepositoryInterface
{
    /**
     * Retrieve DocumentEntity with applied events
     */
    public function get(Uuid $uuid): EntityInterface;

    /**
     * Save DocumentEntity last uncommitted events
     */
    public function store(EntityInterface $entity): void;
}
