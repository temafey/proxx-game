<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Event;

use Assert\Assertion;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use MicroModule\Common\Domain\Event\AbstractEvent;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;

/**
 * @class BoardCreatedEvent
 *
 * @package Micro\Game\Proxx\Domain\Event
 */
class BoardCreatedEvent extends AbstractEvent
{
    /**
     * Board value object.
     */
    protected Board $board;

    /**
     * Constructor
     */
    public function __construct(ProcessUuid $processUuid, Uuid $uuid, Board $board, ?Payload $payload = null)
    {
		$this->board = $board;
		parent::__construct($processUuid, $uuid, $payload);
        
    }

    /**
     * Return Board value object.
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Initialize event from data array.
     */
    public static function deserialize(array $data): static
    {
		Assertion::keyExists($data, 'process_uuid');
		Assertion::keyExists($data, 'uuid');
		Assertion::keyExists($data, 'board');
		$event = new static(
			ProcessUuid::fromNative($data['process_uuid']),
			Uuid::fromNative($data['uuid']),
            Board::fromNative($data['board'])
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
			'board' => $this->getBoard()->toNative(),
		];

		if ($this->payload !== null) {
			$data['payload'] = $this->payload->toNative();
		}

        return $data;
    }
}
