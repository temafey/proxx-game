<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use Micro\Game\Proxx\Domain\Entity\BoardEntity;
use Micro\Game\Proxx\Domain\ValueObject\Board;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;

/**
 * @class EntityFactory
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
class EntityFactory implements EntityFactoryInterface
{
    /**
     * Create BoardEntity instance from value object with Uuid & ProcessId.
     */
    public function createInstance(
        ProcessUuid $processUuid,
        Uuid $uuid,
        Board $board,
        ?Payload $payload = null,
        ?EventFactoryInterface $eventFactory = null
    ): BoardEntityInterface {
        return BoardEntity::create(
			$processUuid, 
			$uuid,
            $board,
			$payload, 
			$eventFactory
		);
    }

    /**
     * Create BoardEntity instance from value object with Uuid.
     *
     * @throws ValueObjectInvalidException
     */
    public function makeActualInstance(
        Uuid $uuid,
        Board $board,
        ?EventFactoryInterface $eventFactory = null
    ): BoardEntityInterface {
        return BoardEntity::createActual(
			$uuid,
            $board,
			$eventFactory
		);
    }
}
