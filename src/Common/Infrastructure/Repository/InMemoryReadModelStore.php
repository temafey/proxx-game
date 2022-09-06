<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Repository;

use MicroModule\Common\Domain\ReadModel\ReadModelInterface;
use MicroModule\Common\Domain\Repository\ReadModelStoreInterface;
use MicroModule\Common\Infrastructure\Repository\Exception\NotFoundException;
use UnexpectedValueException;

/**
 * In-memory implementation of Snapshot store
 *
 * Notice: Useful for testing code
 */
class InMemoryReadModelStore implements ReadModelStoreInterface
{
    /**
     * ReadModels in memory storage
     */
    protected array $readModels = [];

    public function __construct(
        protected string $primaryKey
    ) {
    }

    /**
     * Finds an object by its primary key/identifier
     */
    public function findOne(string $uuid): array
    {
        if (array_key_exists($uuid, $this->readModels)) {
            return $this->readModels[$uuid];
        }

        throw new NotFoundException(sprintf('ReadModel not found for aggregate with id %s', $uuid));
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     * @throws UnexpectedValueException
     *
     * @suppress PhanUnusedPublicFinalMethodParameter, PhanUnusedPublicMethodParameter
     */
    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        return $this->readModels;
    }

    /**
     * Finds a single object by a set of criteria
     *
     * @suppress PhanUnusedPublicFinalMethodParameter
     */
    public function findOneBy(array $criteria): array
    {
        if (array_key_exists($this->primaryKey, $criteria)) {
            return $this->readModels[$criteria[$this->primaryKey]];
        }

        throw new NotFoundException('Primary key not found in criteria');
    }

    /**
     * Insert new user into storage
     */
    public function insertOne(ReadModelInterface $readModel): void
    {
        $this->readModels[$readModel->getPrimaryKeyValue()] = $readModel->normalize();
    }

    /**
     * Update specific row in memory Store
     */
    public function updateOne(ReadModelInterface $readModel): void
    {
        $uuid = $readModel->getPrimaryKeyValue();
        $this->readModels[$uuid] = array_merge($this->readModels[$uuid], $readModel->normalize());
    }

    /**
     * Delete specific row in memory Store
     */
    public function deleteOne(ReadModelInterface $readModel): void
    {
        unset($this->readModels[$readModel->getPrimaryKeyValue()]);
    }
}
