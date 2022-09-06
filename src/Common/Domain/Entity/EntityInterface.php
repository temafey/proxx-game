<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Entity;

use Broadway\Domain\AggregateRoot;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;

interface EntityInterface extends AggregateRoot
{
    public const KEY_PROCESS_UUID = 'process_uuid';
    public const KEY_UUID = 'uuid';

    /**
     * Get ProcessUuid value object
     */
    public function getProcessUuid(): ?ProcessUuid;

    /**
     * Get Entity primary key value
     */
    public function getPrimaryKeyValue();

    /**
     * Get Uuid value object
     */
    public function getUuid(): ?Uuid;
}
