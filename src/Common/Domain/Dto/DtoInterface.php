<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Dto;

interface DtoInterface
{
    public const KEY_VERSION = 'version';
    public const KEY_UUID = 'uuid';

    /**
     * Get version
     */
    public function getVersion(): string;

    /**
     * Get Uuid value
     */
    public function getUuid(): ?string;
}
