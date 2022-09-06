<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\ReadModel;

interface ReadModelInterface
{
    /**
     * Return entity primary key value
     */
    public function getPrimaryKeyValue();

    /**
     * Convert entity object to array
     *
     * @return array<string, mixed>
     */
    public function normalize(): array;
}
