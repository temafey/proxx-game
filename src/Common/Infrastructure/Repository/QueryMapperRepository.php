<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Repository;

use Exception;
use MicroModule\Base\Utils\LoggerTrait;
use MicroModule\Common\Domain\Repository\QueryLiteRepositoryInterface;
use MicroModule\Common\Domain\Repository\ReadModelStoreInterface;
use MicroModule\Common\Domain\ValueObject\FindCriteria;
use MicroModule\Common\Domain\ValueObject\Uuid;
use MicroModule\Common\Infrastructure\Repository\Exception\NotFoundException;
use MicroModule\Common\Infrastructure\Service\DataMapper\DataMapperInterface;

class QueryMapperRepository implements QueryLiteRepositoryInterface
{
    use LoggerTrait;

    public function __construct(
        protected ReadModelStoreInterface $readModelStore,
        protected DataMapperInterface $dbalDataMapper
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function findByUuid(Uuid $uuid): ?array
    {
        try {
            return $this->dbalDataMapper->mapFromStorage(
                $this->readModelStore->findOne($uuid->toNative())
            );
        } catch (NotFoundException) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findByCriteria(FindCriteria $findCriteria): ?array
    {
        try {
            return $this->dbalDataMapper->mapFromStorage(
                $this->readModelStore->findBy($findCriteria->toNative())
            );
        } catch (NotFoundException) {
            return null;
        }
    }
}
