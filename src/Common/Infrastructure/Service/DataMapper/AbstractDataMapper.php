<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper;

use MicroModule\Common\Infrastructure\Service\DataMapper\Types\TypeRegistry;

abstract class AbstractDataMapper implements DataMapperInterface
{
    public function __construct(
        protected TypeRegistry $typeFactory
    ) {
    }

    public function mapToStorage(array $data): array
    {
        $mappedData = [];
        $fieldTypes = $this->getFieldTypes();

        foreach ($data as $fieldName => $value) {
            if (false === isset($fieldTypes[$fieldName])) {
                $mappedData[$fieldName] = $value;

                continue;
            }

            $type = $this->typeFactory->getType($fieldTypes[$fieldName]);
            $mappedData[$fieldName] = $type->convertToStorageValue($value);
        }

        return $mappedData;
    }

    public function mapFromStorage(array $data): array
    {
        $mappedData = [];
        $fieldTypes = $this->getFieldTypes();

        foreach ($data as $fieldName => $value) {
            if (!isset($fieldTypes[$fieldName])) {
                $mappedData[$fieldName] = $value;

                continue;
            }

            $type = $this->typeFactory->getType($fieldTypes[$fieldName]);
            $mappedData[$fieldName] = $type->convertFromStorageValue($value);
        }

        return $mappedData;
    }

    /**
     * Get fields types list
     */
    abstract protected function getFieldTypes(): array;
}
