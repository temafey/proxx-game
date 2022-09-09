<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\ValueObject;

use InvalidArgumentException;
use Micro\Game\Proxx\Domain\Entity\CellEntityInterface;
use MicroModule\ValueObject\ValueObjectInterface;

/**
 * @class Cells
 *
 * @package Micro\Game\Proxx\Domain\ValueObject
 */
class Cells implements ValueObjectInterface
{
    /**
     * Cell collection.
     */
    protected array $items;

    /**
     * Board width.
     */
    protected int $width = 0;

    /**
     * Collection constructor.
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        $this->width = count($items);
    }

    /**
     * Returns a new Collection object.
     */
    public static function fromNative(): static
    {
        $array = func_get_arg(0);

        if (!is_iterable($array)) {
            throw new InvalidArgumentException('Invalid argument type, expected array.');
        }
        $width = count($array);
        $items = [];

        foreach ($array as $x => $row) {
            if (!is_iterable($row)) {
                throw new InvalidArgumentException('Invalid argument type, expected array.');
            }
            foreach ($row as $y => $cell) {
                if (is_array($cell)) {
                    $cell = Cell::fromNative($cell);
                }
                $items[self::generateKeyFromCoordinate((int) $x, (int) $y, $width)] = $cell;
            }
        }

        return new static($items);
    }

    /**
     * Returns a new Collection object.
     */
    public static function fromArray(array $array): static
    {
        $items = [];

        foreach ($array as $pos => $cell) {
            if (is_array($cell)) {
                $cell = Cell::fromNative($cell);
            }
            $items[$pos] = $cell;
        }

        return new static($items);
    }

    public function getFromCollectionWithCoordinate(int $x, int $y): Cell
    {
        return $this->items[$this->generateKeyFromCoordinate($x, $y, $this->width)];
    }

    public static function generateKeyFromCoordinate(int $x, int $y, int $width): int
    {
        return $x * $width + $y;
    }

    /**
     * @return Cell[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Tells whether two Collection are equal by comparing their size and items (item order matters).
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $collection): bool
    {
        if (!$collection instanceof static) {
            return false;
        }

        if ($this->count() === $collection->count()) {
            return false;
        }
        $arrayCollection = $collection->toArray();

        foreach ($this->items as $index => $item) {
            if (!isset($arrayCollection[$index]) || false === $item->sameValueAs($arrayCollection[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the number of objects in the collection.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Return native value.
     */
    public function toNative(): array
    {
        return $this->toArray();
    }

    /**
     * Returns a native array representation of the Collection.
     *
     * @SuppressWarnings(PHPMD)
     */
    public function toArray(bool $native = true): array
    {
        if (false === $native) {
            return $this->items;
        }
        $items = [];

        foreach ($this->items as $pos => $item) {
            if ($item instanceof CellEntityInterface) {
                $item = $item->assembleToValueObject();
            }
            if ($item instanceof ValueObjectInterface) {
                $item = $item->toNative();
            }
            $items[$pos] = $item;
        }

        return $items;
    }

    /**
     * Returns a native string representation of the Collection object.
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }
}
