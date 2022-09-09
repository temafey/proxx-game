<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\ValueObject;

use Broadway\Serializer\Serializable;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidNativeValueException;
use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\ValueObject\ValueObjectInterface;
use Micro\Game\Proxx\Domain\ValueObject\HasBlackHole;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHolesAround;
use Micro\Game\Proxx\Domain\ValueObject\PositionX;
use Micro\Game\Proxx\Domain\ValueObject\PositionY;
use Micro\Game\Proxx\Domain\ValueObject\WasMarked;
use Micro\Game\Proxx\Domain\ValueObject\WasOpened;

/**
 * @class Cell
 *
 * @package Micro\Game\Proxx\Domain\ValueObject
 */
class Cell implements Serializable, ValueObjectInterface
{
    /**
     * Fields, that should be compared.
     */
    public const COMPARED_FIELDS = [
		'position-x',
		'position-y',
		'has-black-hole',
		'number-of-black-holes-around',
		'was-opened',
		'was-marked',
		'created_at',
		'updated_at',
	];

    /**
     * Return PositionX value object.
     */
    protected ?PositionX $positionX = null;

    /**
     * Return PositionY value object.
     */
    protected ?PositionY $positionY = null;

    /**
     * Return HasBlackHole value object.
     */
    protected ?HasBlackHole $hasBlackHole = null;

    /**
     * Return NumberOfBlackHolesAround value object.
     */
    protected ?NumberOfBlackHolesAround $numberOfBlackHolesAround = null;

    /**
     * Return WasOpened value object.
     */
    protected ?WasOpened $wasOpened = null;

    /**
     * Return WasMarked value object.
     */
    protected ?WasMarked $wasMarked = null;

    /**
     * Make Cell from DTO object or serialized string.
     *
     * @return Cell
     *
     * @throws Exception
     */
    public static function fromNative(): static
    {
        $data = func_get_arg(0);

        if (is_array($data)) {
            return static::fromArray($data);
        }

        if (is_string($data)) {
            $data = unserialize($data, ['allowed_classes' => false]);

            return static::fromArray($data);
        }

        throw new ValueObjectInvalidNativeValueException('Invalid native value');
    }

    /**
     * Tells whether two Collection are equal by comparing their size.
     *
     * @throws ValueObjectInvalidException
     */
    public function sameValueAs(ValueObjectInterface $valueObject): bool
    {
        if (!$valueObject instanceof static) {
            return false;
        }

        foreach (static::COMPARED_FIELDS as $field) {
            $getMethodName = 'get' . ucfirst($field);
            $field = $this->{$getMethodName}();
            $property = $valueObject->{$getMethodName}();

            if (null === $field && null === $property) {
                continue;
            }

            if (null === $field || null === $property) {
                return false;
            }

            if (
                !$field instanceof ValueObjectInterface ||
                !$property instanceof ValueObjectInterface
            ) {
                throw new ValueObjectInvalidException('Some of value not instance of \'ValueObjectInterface\'');
            }

            if (!$field->sameValueAs($property)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return native value.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function toNative()
    {
        return $this->toArray();
    }

    /**
     * Returns a native string representation of the Collection object.
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Convert array to ValueObject.
     *
     * @param mixed[] $data
     *
     * @throws Exception
     */
    public static function deserialize(array $data): self
    {
        return static::fromNative($data);
    }

    /**
     * Convert ValueObject to array.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function serialize(): array
    {
        return $this->toNative();
    }

    /**
     * Build Cell object from array.
     */
    public static function fromArray(array $data): static
    {
		$valueObject = new static();
		if (isset($data['position-x'])) {
			$valueObject->positionX = PositionX::fromNative($data['position-x']);
		}

		if (isset($data['position-y'])) {
			$valueObject->positionY = PositionY::fromNative($data['position-y']);
		}

		if (isset($data['has-black-hole'])) {
			$valueObject->hasBlackHole = HasBlackHole::fromNative($data['has-black-hole']);
		}

		if (isset($data['number-of-black-holes-around'])) {
			$valueObject->numberOfBlackHolesAround = NumberOfBlackHolesAround::fromNative($data['number-of-black-holes-around']);
		}

		if (isset($data['was-opened'])) {
			$valueObject->wasOpened = WasOpened::fromNative($data['was-opened']);
		}

		if (isset($data['was-marked'])) {
			$valueObject->wasMarked = WasMarked::fromNative($data['was-marked']);
		}

        return $valueObject;
    }

    /**
     * Build Cell object from array.
     */
    public function toArray(): array
    {
		$data = [];
		if (null !== $this->positionX) {
			$data['position-x'] = $this->positionX->toNative();
		}

		if (null !== $this->positionY) {
			$data['position-y'] = $this->positionY->toNative();
		}

		if (null !== $this->hasBlackHole) {
			$data['has-black-hole'] = $this->hasBlackHole->toNative();
		}

		if (null !== $this->numberOfBlackHolesAround) {
			$data['number-of-black-holes-around'] = $this->numberOfBlackHolesAround->toNative();
		}

		if (null !== $this->wasOpened) {
			$data['was-opened'] = $this->wasOpened->toNative();
		}

		if (null !== $this->wasMarked) {
			$data['was-marked'] = $this->wasMarked->toNative();
		}

        return $data;
    }

    /**
     * Return PositionX value object.
     */
    public function getPositionX(): ?PositionX
    {
        return $this->positionX;
    }

    /**
     * Return PositionY value object.
     */
    public function getPositionY(): ?PositionY
    {
        return $this->positionY;
    }

    /**
     * Return HasBlackHole value object.
     */
    public function getHasBlackHole(): ?HasBlackHole
    {
        return $this->hasBlackHole;
    }

    /**
     * Return NumberOfBlackHolesAround value object.
     */
    public function getNumberOfBlackHolesAround(): ?NumberOfBlackHolesAround
    {
        return $this->numberOfBlackHolesAround;
    }

    /**
     * Return WasOpened value object.
     */
    public function getWasOpened(): ?WasOpened
    {
        return $this->wasOpened;
    }

    /**
     * Return WasMarked value object.
     */
    public function getWasMarked(): ?WasMarked
    {
        return $this->wasMarked;
    }

}
