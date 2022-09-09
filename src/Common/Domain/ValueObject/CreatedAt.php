<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\ValueObject;

use MicroModule\ValueObject\DateTime\DateTime;
use MicroModule\ValueObject\DateTime\Exception\InvalidDateException;

class CreatedAt extends DateTime
{
    /**
     * Returns a new DateTime object from native values.
     *
     * @throws InvalidDateException|Exception
     */
    public static function fromNative(): static
    {
        $args = func_get_args();

        return is_array($args[0]) && isset($args[0]['date']) ? parent::fromNative($args[0]['date']) : parent::fromNative($args[0]);
    }
}
