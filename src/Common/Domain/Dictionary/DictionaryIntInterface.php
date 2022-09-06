<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Dictionary;

interface DictionaryIntInterface extends DictionaryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(string $type): int;

    /**
     * Get type alias with type id
     */
    public function getTypeWithId(int $id): string;
}
