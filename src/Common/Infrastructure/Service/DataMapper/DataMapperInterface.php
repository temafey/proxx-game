<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper;

interface DataMapperInterface
{
    /**
     * Map data to storage
     */
    public function mapToStorage(array $data): array;

    /**
     * Map data from storage
     */
    public function mapFromStorage(array $data): array;
}
