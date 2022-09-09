<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\ValueObject;

use MicroModule\ValueObject\Exception\InvalidNativeArgumentException;
use MicroModule\ValueObject\Number\Integer as BaseNumberInteger;

/**
 * @class GameStatus
 *
 * @package Micro\Game\Proxx\Domain\ValueObject
 */
class GameStatus extends BaseNumberInteger
{
    public const GAME_IN_PROGRESS = 0;
    public const GAME_FINISH_SUCCESSFULLY = 1;
    public const GAME_FINISH_UNSUCCESSFULLY = 2;

    public const GAME_STATUSES = [
        self::GAME_IN_PROGRESS,
        self::GAME_FINISH_SUCCESSFULLY,
        self::GAME_FINISH_UNSUCCESSFULLY
    ];

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

    public static function fromNative(): static
    {
        $value = func_get_arg(0);
        $value = filter_var($value, FILTER_VALIDATE_INT);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int']);
        }
        if (!in_array($value, self::GAME_STATUSES)) {
            throw new InvalidNativeArgumentException($value, self::GAME_STATUSES);
        }

        return new static($value);
    }

    /**
     * Is game in progress.
     */
    public function isGameInProgress(): bool
    {
        return $this->value === self::GAME_IN_PROGRESS;
    }

    /**
     * Is game finish successfully.
     */
    public function isGameFinishSuccessfully(): bool
    {
        return $this->value === self::GAME_FINISH_SUCCESSFULLY;
    }

    /**
     * Is game finish unsuccessfully.
     */
    public function isGameFinishUnsuccessfully(): bool
    {
        return $this->value === self::GAME_FINISH_UNSUCCESSFULLY;
    }
}
