<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;
use MicroModule\ValueObject\Number\Integer as BaseNumberInteger;

/**
 * @class WasOpened
 *
 * @package Micro\Game\Proxx\Domain\ValueObject
 */
class WasOpened extends BaseNumberInteger
{
    /**
     * Returns a Integer object given a PHP native int as parameter.
     */
    public function __construct()
    {
        $this->value = 1;
    }

    #[Pure] public static function fromNative(): static
    {
        return new static();
    }

    /**
     * Increment value.
     */
    public function inc(): static
    {
        return $this;
    }

    /**
     * Decrement value.
     */
    public function decr(): static
    {
        return $this;
    }
}
