<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;

/**
 * @class BlackHolesAroundSetedEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class BlackHolesAroundSetedEvent extends AbstractEvent
{
    /**
     * NumberOfBlackHolesAround value object.
     */
    protected NumberOfBlackHolesAround $numberOfBlackHolesAround;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, NumberOfBlackHolesAround $numberOfBlackHolesAround, ?Payload $payload = null)
    {
		$this->numberOfBlackHolesAround = $numberOfBlackHolesAround;
		parent::__construct($processUuid, $uuid, $payload);
        
    }

    /**
     * Return NumberOfBlackHolesAround value object.
     */
    public function getNumberOfBlackHolesAround(): NumberOfBlackHolesAround
    {
        return $this->numberOfBlackHolesAround;
    }

    /**
     * Initialize event from data array.
     */
    public static function deserialize(array $data): static
    {
		Assertion::keyExists($data, 'process_uuid');
		Assertion::keyExists($data, 'number-of-black-holes-around');
		$event = new static(
			ProcessUuid::fromNative($data['process_uuid']),
			NumberOfBlackHolesAround::fromNative($data['number-of-black-holes-around'])
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
			'number-of-black-holes-around' => $this->getNumberOfBlackHolesAround()->toNative()
		];

		if ($this->payload !== null) {
			$data['payload'] = $this->payload->toNative();
		}

        return $data;
    }
}
