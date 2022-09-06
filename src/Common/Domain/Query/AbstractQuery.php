<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Query;

use Exception;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractQuery implements QueryInterface
{
    public function __construct(
        protected ProcessUuid $processUuid,
        protected UuidInterface $uuid
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessUuid(): ProcessUuid
    {
        return $this->processUuid;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid->getUuid();
    }
}
