<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Service\DataMapper\Types;

use MicroModule\Common\Infrastructure\Service\DataMapper\Exception\TypeNotExistsException;

class TypeRegistry
{
    /**
     * Available types list
     *
     * @var array<TypeInterface>
     */
    protected array $types;

    /**
     * Add new data mapping type to the list of available ones.
     */
    public function addType(TypeInterface $type): static
    {
        $this->types[$type::class] = $type;

        return $this;
    }

    /**
     * Get data mapping type from the list of available ones.
     *
     * @throws TypeNotExistsException
     */
    public function getType(string $typeClass): TypeInterface
    {
        if (!isset($this->types[$typeClass])) {
            throw TypeNotExistsException::fromTypeClass($typeClass);
        }

        return $this->types[$typeClass];
    }
}
