<?php

namespace MicroModule\Common\Domain\Event;

use Broadway\Serializer\Serializable;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;

interface EventInterface extends Serializable
{
    public const KEY_UUID = 'uuid';
    public const KEY_PROCESS_UUID = 'process_uuid';
    public const KEY_PAYLOAD = 'entity_payload';

    /**
     * Get Process uuid
     */
    public function getProcessUuid(): ProcessUuid;

    /**
     * Return entity payload.
     */
    public function getPayload(): ?Payload;

    /**
     * Set entity payload.
     */
    public function setPayload(?Payload $payload): void;
}
