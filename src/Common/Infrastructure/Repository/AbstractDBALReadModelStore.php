<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Statement as DriverStatement;
use MicroModule\Common\Domain\ReadModel\ReadModelInterface;
use MicroModule\Common\Domain\Repository\ReadModelStoreInterface;
use MicroModule\Common\Infrastructure\Repository\Exception\DBALEventStoreException;
use MicroModule\Common\Infrastructure\Repository\Exception\NotFoundException;
use MicroModule\Common\Infrastructure\Service\DataMapper\DataMapperInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
abstract class AbstractDBALReadModelStore implements ReadModelStoreInterface
{
    public function __construct(
        protected Connection $connection,
        protected string $tableName,
        protected string $primaryKey,
        protected DataMapperInterface $dataMapper
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     * @throws Exception
     */
    public function findOne(string $uuid): array
    {
        $statement = $this->prepareSelectStatement([$this->primaryKey => $uuid]);
        $result = $statement->executeQuery();
        $row = $result->fetchAssociative();

        if (false === $row) {
            throw new NotFoundException(
                sprintf(
                    'ReadModel not found for aggregate with id %s for table %s',
                    $uuid,
                    $this->tableName
                )
            );
        }

        return $row;
    }

    /**
     * Prepare query
     *
     * @throws DBALException
     */
    protected function prepareSelectStatement(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): DriverStatement {
        $query = $this->getDefaultQuery();
        [$values, $conditions] = $this->gatherConditions($criteria);

        if ($conditions) {
            $query .= '
                WHERE ' . implode(' AND ', $conditions);
        }
        if (null !== $orderBy) {
            $query .= ' ORDER BY ' . implode(', ', $orderBy);
        }
        if (null !== $limit) {
            $query .= ' LIMIT ' . $limit;
        }
        if ($offset > 0) {
            $query .= ' OFFSET ' . $offset;
        }

        $statement = $this->connection->prepare($query);

        foreach ($values as $param => $value) {
            $statement->bindValue($param, $value);
        }

        return $statement;
    }

    /**
     * Return Default query
     */
    abstract protected function getDefaultQuery(): string;

    /**
     * Prepare query conditions
     */
    protected function prepareQueryConditions(
        string $query,
        array $conditions,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): string {
        $query .= ' WHERE ' . implode(' AND ', $conditions);

        if (null !== $orderBy) {
            $query .= ' ORDER BY ' . implode(', ', $orderBy);
        }

        if (null !== $limit) {
            $query .= ' LIMIT ' . $limit;
        }

        if (null !== $offset && $offset > 0) {
            $query .= ' OFFSET ' . $offset;
        }

        return $query;
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @throws DBALException
     * @throws Exception
     */
    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $statement = $this->prepareSelectStatement($criteria, $orderBy, $limit, $offset);

        return $statement->executeQuery()->fetchAllAssociative();
    }

    /**
     * Gathers conditions for an update or delete call.
     *
     * @param mixed[] $identifiers Input array of columns to values
     *
     * @return string[][] a triplet with:
     *                    - the second key being the values
     *                    - the third key being the conditions
     */
    protected function gatherConditions(array $identifiers): array
    {
        $values = [];
        $conditions = [];
        $valueKey = 0;

        foreach ($identifiers as $columnName => $value) {
            ++$valueKey;
            $values[$valueKey] = $value;
            $conditions[] = $columnName . ' = ?';
        }

        return [$values, $conditions];
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     * @throws Exception
     */
    public function findOneBy(array $criteria): array
    {
        $statement = $this->prepareSelectStatement($criteria, null, 1);
        $result = $statement->executeQuery();
        $row = $result->fetchAssociative();

        if (false === $row) {
            throw new NotFoundException(
                sprintf(
                    'ReadModel not found for aggregate with id %s for table %s',
                    implode(', ', $criteria),
                    $this->tableName
                )
            );
        }

        return $row;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function insertOne(ReadModelInterface $readModel): void
    {
        $this->connection->beginTransaction();

        try {
            $this->insert($this->connection, $readModel->getPrimaryKeyValue(), $readModel->normalize());
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }
    }

    /**
     * Insert new user data to store
     *
     * @throws DBALException
     */
    protected function insert(Connection $connection, string $primaryKeyValue, array $data): void
    {
        $insert = $this->dataMapper->mapToStorage($data);
        $insert[$this->primaryKey] = $primaryKeyValue;
        $connection->insert($this->tableName, $insert);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function updateOne(ReadModelInterface $readModel): void
    {
        $this->connection->beginTransaction();

        try {
            $this->update(
                $this->connection,
                $readModel->normalize(),
                [$this->primaryKey => $readModel->getPrimaryKeyValue()]
            );
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }
    }

    /**
     * Update data to store
     *
     * @throws DBALException
     */
    protected function update(Connection $connection, array $data, array $conditions): void
    {
        $update = $this->dataMapper->mapToStorage($data);
        $connection->update($this->tableName, $update, $conditions);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConnectionException
     * @throws DBALEventStoreException
     */
    public function deleteOne(ReadModelInterface $readModel): void
    {
        $this->connection->beginTransaction();

        try {
            $this->delete($this->connection, [$this->primaryKey => $readModel->getPrimaryKeyValue()]);
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw new DBALEventStoreException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }
    }

    /**
     * Delete user from store
     *
     * @throws DBALException
     */
    protected function delete(Connection $connection, array $conditions): void
    {
        $connection->delete($this->tableName, $conditions);
    }
}
