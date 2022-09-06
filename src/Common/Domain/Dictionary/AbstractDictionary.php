<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Dictionary;

use Exception;

abstract class AbstractDictionary implements DictionaryInterface
{
    /**
     * @return array<string,mixed>
     */
    abstract protected function getTypes(): array;

    /**
     * {@inheritdoc}
     */
    public function hasType(string $type): bool
    {
        return array_key_exists($type, $this->getTypes());
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function getType(string $type)
    {
        if (false === $this->hasType($type)) {
            throw new Exception(sprintf('Type `%s` is missed', $type));
        }

        return $this->getTypes()[$type];
    }
}
