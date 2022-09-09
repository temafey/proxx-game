<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use Micro\Game\Proxx\Domain\ValueObject\Cells;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;

/**
 * @class CellsInstalledEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class CellsInstalledEvent extends AbstractEvent
{
    /**
     * Cells value object.
     */
    protected Cells $cells;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Cells $cells, ?Payload $payload = null)
    {
		$this->cells = $cells;
		parent::__construct($processUuid, $uuid, $payload);
        
    }

    /**
     * Return cells array.
     */
    public function getCells(): Cells
    {
        return $this->cells;
    }

    /**
     * Initialize event from data array.
     */
    public static function deserialize(array $data): static
    {
		Assertion::keyExists($data, 'process_uuid');
		Assertion::keyExists($data, 'uuid');
		Assertion::keyExists($data, 'cells');
		$event = new static(
			ProcessUuid::fromNative($data['process_uuid']),
			Uuid::fromNative($data['uuid']),
            Cells::fromArray($data['cells']),
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
			'cells' => $this->getCells()->toNative(),
		];

		if ($this->payload !== null) {
			$data['payload'] = $this->payload->toNative();
		}

        return $data;
    }
}
