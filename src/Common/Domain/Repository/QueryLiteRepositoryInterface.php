<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Repository;

use MicroModule\Common\Domain\ValueObject\FindCriteria;
use MicroModule\Common\Domain\ValueObject\Uuid;

interface QueryLiteRepositoryInterface
{
    /**
     * Find and return User by uuid
     */
    public function findByUuid(Uuid $uuid): ?array;

    /**
     * Find and return array of Users by FindCriteria
     */
    public function findByCriteria(FindCriteria $findCriteria): ?array;
}
