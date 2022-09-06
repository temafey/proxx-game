<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\QueryHandler;

use MicroModule\Common\Domain\Query\QueryInterface;

interface QueryHandlerInterface
{
    /**
     * Handle specific query
     */
    public function handle(QueryInterface $query): ?array;
}
