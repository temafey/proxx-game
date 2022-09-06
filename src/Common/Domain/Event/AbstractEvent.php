<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Exception;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

abstract class AbstractEvent implements EventInterface
{
    protected ?Payload $payload = null;

    public function __construct(
        protected ProcessUuid $processUuid,
        protected Uuid $uuid,
        ?Payload $payload = null
    ) {
        $this->payload = $payload;
    }

    /**
     * {@inheritdoc}
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
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
     * @throws AssertionFailedException
     * @throws Exception
     */
    public static function deserialize(array $data): static
    {
        if (__CLASS__ === static::class) {
            throw new RuntimeException('You can`t instantiate abstract class');
        }
        Assertion::keyExists($data, self::KEY_PROCESS_UUID);
        Assertion::keyExists($data, self::KEY_UUID);

        $event = new static(
            ProcessUuid::fromNative($data[self::KEY_PROCESS_UUID]),
            Uuid::fromNative($data[self::KEY_UUID])
        );

        if (isset($data[self::KEY_PAYLOAD])) {
            $event->setPayload(Payload::fromNative($data[self::KEY_PAYLOAD]));
        }

        return $event;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(): array
    {
        $data = [
            self::KEY_PROCESS_UUID => $this->processUuid->toNative(),
            self::KEY_UUID => $this->uuid->toNative(),
        ];

        if (null !== $this->payload) {
            $data[self::KEY_PAYLOAD] = $this->payload->toNative();
        }

        return $data;
    }

    /**
     * Return entity payload.
     */
    public function getPayload(): ?Payload
    {
        return $this->payload;
    }

    /**
     * Set entity payload.
     */
    public function setPayload(?Payload $payload): void
    {
        $this->payload = $payload;
    }
}
