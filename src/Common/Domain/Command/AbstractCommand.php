<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Command;

use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * Return ProcessUuid value object.
     */
    protected ProcessUuid $processUuid;

    /**
     * Return Uuid value object.
     */
    protected UuidInterface $uuid;

    public function __construct(ProcessUuid $processUuid, UuidInterface $uuid)
    {
        $this->processUuid = $processUuid;
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessUuid(): ProcessUuid
    {
        return $this->processUuid;
    }
    
    /**
     * Return Uuid value object.
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
