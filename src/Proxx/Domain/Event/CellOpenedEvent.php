<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;

/**
 * @class CellOpenedEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class CellOpenedEvent extends AbstractEvent
{
    /**
     * PositionX value object.
     */
    protected PositionX $positionX;

    /**
     * PositionY value object.
     */
    protected PositionY $positionY;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, PositionX $positionX, PositionY $positionY, ?Payload $payload = null)
    {
		$this->positionX = $positionX;
		$this->positionY = $positionY;
		parent::__construct($processUuid, $uuid, $payload);
        
    }

    /**
     * Return PositionX value object.
     */
    public function getPositionX(): PositionX
    {
        return $this->positionX;
    }

    /**
     * Return PositionY value object.
     */
    public function getPositionY(): PositionY
    {
        return $this->positionY;
    }

    /**
     * Initialize event from data array.
     */
    public static function deserialize(array $data): static
    {
		Assertion::keyExists($data, 'process_uuid');
		Assertion::keyExists($data, 'uuid');
		Assertion::keyExists($data, 'position-x');
		Assertion::keyExists($data, 'position-y');
		$event = new static(
			ProcessUuid::fromNative($data['process_uuid']),
			Uuid::fromNative($data['uuid']),
			PositionX::fromNative($data['position-x']),
			PositionY::fromNative($data['position-y'])
		);

		if (isset($data['payload'])) {
			$event->setPayload(Payload::fromNative($data['payload']));
		}

        return $event;
    }

    /**
     * Convert event object to array.
     */
    public function serialize(): array
    {
		$data = [
			'process_uuid' => $this->getProcessUuid()->toNative(),
			'uuid' => $this->getUuid()->toNative(),
			'position-x' => $this->getPositionX()->toNative(),
			'position-y' => $this->getPositionY()->toNative()
		];

		if ($this->payload !== null) {
			$data['payload'] = $this->payload->toNative();
		}

        return $data;
    }
}
