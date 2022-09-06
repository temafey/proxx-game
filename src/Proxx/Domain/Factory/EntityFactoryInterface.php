<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\Factory;

use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use Micro\Game\Proxx\Domain\ValueObject\Proxx;

/**
 * @interface EntityFactoryInterface
 *
 * @package Micro\Game\Proxx\Domain\Factory
 */
interface EntityFactoryInterface
{
    /**
     * Create ProxxEntity instance from value object with Uuid & ProcessId.
     */
    public function createInstance(
        ProcessUuid $processUuid,
        Uuid $uuid,
        Proxx $proxx,
        ?Payload $payload = null,
        ?EventFactoryInterface $eventFactory = null
    ): BoardEntityInterface;

    /**
     * Create ProxxEntity instance from value object with Uuid.
     *
     * @throws ValueObjectInvalidException
     */
    public function makeActualInstance(
        Uuid $uuid,
        Proxx $proxx,
        ?EventFactoryInterface $eventFactory = null
    ): BoardEntityInterface;
}
