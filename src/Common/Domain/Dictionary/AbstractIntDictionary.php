<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Dictionary;

abstract class AbstractIntDictionary extends AbstractDictionary implements DictionaryIntInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(string $type): int
    {
        return (int)parent::getType($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeWithId(int $id): string
    {
        return array_search($id, $this->getTypes());
    }
}
