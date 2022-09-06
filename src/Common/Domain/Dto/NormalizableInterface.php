<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Dto;

interface NormalizableInterface
{
    /**
     * Convert array to DTO object
     */
    public static function denormalize(array $data);

    /**
     * Convert object DTO to array
     */
    public function normalize(): array;
}
