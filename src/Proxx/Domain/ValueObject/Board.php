<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Domain\ValueObject;

use Broadway\Serializer\Serializable;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidException;
use MicroModule\Common\Domain\Exception\ValueObjectInvalidNativeValueException;
use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\ValueObject\ValueObjectInterface;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfMarkedBlackHoles;
use Micro\Game\Proxx\Domain\ValueObject\NumberOfOpenedCells;
use Micro\Game\Proxx\Domain\ValueObject\Width;

/**
 * @class Board
 *
 * @package Micro\Game\Proxx\Domain\ValueObject
 */
class Board implements Serializable, ValueObjectInterface
{
    /**
     * Fields, that should be compared.
     */
    public const COMPARED_FIELDS = [
		"width",
		"number-of-black-holes",
		"number-of-opened-cells",
		"number-of-marked-black-holes",
	];

    /**
     * Width value object.
     */
    protected Width $width;

    /**
     * NumberOfBlackHoles value object.
     */
    protected NumberOfBlackHoles $numberOfBlackHoles;

    /**
     * NumberOfOpenedCells value object.
     */
    protected ?NumberOfOpenedCells $numberOfOpenedCells = null;

    /**
     * NumberOfMarkedBlackHoles value object.
     */
    protected ?NumberOfMarkedBlackHoles $numberOfMarkedBlackHoles = null;

    /**
     * GameStatus value object.
     */
    protected ?GameStatus $gameStatus = null;

    /**
     * Return CreatedAt value object.
     */
    protected ?CreatedAt $createdAt = null;

    /**
     * Return UpdatedAt value object.
     */
    protected ?UpdatedAt $updatedAt = null;

    /**
     * Make Board from DTO object or serialized string.
     *
     * @return Board
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
            $data = unserialize($data, ["allowed_classes" => false]);

            return static::fromArray($data);
        }

        throw new ValueObjectInvalidNativeValueException("Invalid native value");
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
            $getMethodName = "get" . ucfirst($field);
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
                throw new ValueObjectInvalidException("Some of value not instance of \"ValueObjectInterface\"");
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
     * Build Board object from array.
     */
    public static function fromArray(array $data): static
    {
		$valueObject = new static();

		if (isset($data["width"])) {
			$valueObject->width = Width::fromNative($data["width"]);
		}

		if (isset($data["number-of-black-holes"])) {
			$valueObject->numberOfBlackHoles = NumberOfBlackHoles::fromNative($data["number-of-black-holes"]);
		}

		if (isset($data["number-of-opened-cells"])) {
			$valueObject->numberOfOpenedCells = NumberOfOpenedCells::fromNative($data["number-of-opened-cells"]);
		}

		if (isset($data["number-of-marked-black-holes"])) {
			$valueObject->numberOfMarkedBlackHoles = NumberOfMarkedBlackHoles::fromNative($data["number-of-marked-black-holes"]);
		}

        if (isset($data["game-status"])) {
            $valueObject->gameStatus = GameStatus::fromNative($data["game-status"]);
        }

		if (isset($data["created_at"])) {
			$valueObject->createdAt = CreatedAt::fromNative($data["created_at"]);
		}

		if (isset($data["updated_at"])) {
			$valueObject->updatedAt = UpdatedAt::fromNative($data["updated_at"]);
		}

        return $valueObject;
    }

    /**
     * Build Board object from array.
     */
    public function toArray(): array
    {
		$data = [];
		if (null !== $this->width) {
			$data["width"] = $this->width->toNative();
		}

		if (null !== $this->numberOfBlackHoles) {
			$data["number-of-black-holes"] = $this->numberOfBlackHoles->toNative();
		}

		if (null !== $this->numberOfOpenedCells) {
			$data["number-of-opened-cells"] = $this->numberOfOpenedCells->toNative();
		}

		if (null !== $this->numberOfMarkedBlackHoles) {
			$data["number-of-marked-black-holes"] = $this->numberOfMarkedBlackHoles->toNative();
		}

        if (null !== $this->gameStatus) {
            $data["game-status"] = $this->gameStatus->toNative();
        }

		if (null !== $this->createdAt) {
			$data["created_at"] = $this->createdAt->toNative();
		}

		if (null !== $this->updatedAt) {
			$data["updated_at"] = $this->updatedAt->toNative();
		}

        return $data;
    }

    /**
     * Return Width value object.
     */
    public function getWidth(): ?Width
    {
        return $this->width;
    }

    /**
     * Return NumberOfBlackHoles value object.
     */
    public function getNumberOfBlackHoles(): ?NumberOfBlackHoles
    {
        return $this->numberOfBlackHoles;
    }

    /**
     * Return NumberOfOpenedCells value object.
     */
    public function getNumberOfOpenedCells(): ?NumberOfOpenedCells
    {
        return $this->numberOfOpenedCells;
    }

    /**
     * Return NumberOfMarkedBlackHoles value object.
     */
    public function getNumberOfMarkedBlackHoles(): ?NumberOfMarkedBlackHoles
    {
        return $this->numberOfMarkedBlackHoles;
    }

    /**
     * Return game status.
     */
    public function getGameStatus(): ?GameStatus
    {
        return $this->gameStatus;
    }

    /**
     * Return CreatedAt value object.
     */
    public function getCreatedAt(): ?CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * Return UpdatedAt value object.
     */
    public function getUpdatedAt(): ?UpdatedAt
    {
        return $this->updatedAt;
    }

}
