<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\ValueObject;

use MicroModule\ValueObject\Identity\UUID as BaseUUID;
use Ramsey\Uuid\Converter\NumberConverterInterface;
use Ramsey\Uuid\Fields\FieldsInterface;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Type\Integer as IntegerObject;
use Ramsey\Uuid\UuidInterface;

class Uuid extends BaseUUID implements UuidInterface
{
    protected int $uuidVersion = self::UUID_VERSION_6;

    /**
     * Returns -1, 0, or 1 if the UUID is less than, equal to, or greater than
     * the other UUID
     *
     * The first of two UUIDs is greater than the second if the most
     * significant field in which the UUIDs differ is greater for the first
     * UUID.
     *
     * * Q. What's the value of being able to sort UUIDs?
     * * A. Use them as keys in a B-Tree or similar mapping.
     *
     * @param UuidInterface $other The UUID to compare
     *
     * @return int -1, 0, or 1 if the UUID is less than, equal to, or greater than $other
     */
    public function compareTo(UuidInterface $other): int
    {
        return $this->uuid->compareTo($other);
    }

    /**
     * Returns true if the UUID is equal to the provided object
     *
     * The result is true if and only if the argument is not null, is a UUID
     * object, has the same variant, and contains the same value, bit for bit,
     * as the UUID.
     *
     *
     * @param object|null $other An object to test for equality with this UUID
     *
     * @return bool True if the other object is equal to this UUID
     */
    public function equals(?object $other): bool
    {
        return $this->uuid->equals($other);
    }

    /**
     * Returns the binary string representation of the UUID
     *
     * @psalm-return non-empty-string
     */
    public function getBytes(): string
    {
        return $this->uuid->getBytes();
    }

    /**
     * Returns the fields that comprise this UUID
     */
    public function getFields(): FieldsInterface
    {
        return $this->uuid->getFields();
    }

    /**
     * Returns the hexadecimal representation of the UUID
     */
    public function getHex(): Hexadecimal
    {
        return $this->uuid->getHex();
    }

    /**
     * Returns the integer representation of the UUID
     */
    public function getInteger(): IntegerObject
    {
        return $this->uuid->getInteger();
    }

    /**
     * Returns the string standard representation of the UUID
     *
     * @psalm-return non-empty-string
     */
    public function toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * Casts the UUID to the string standard representation
     *
     * @psalm-return non-empty-string
     */
    public function __toString(): string
    {
        return $this->uuid->__toString();
    }

    /**
     * String representation of object.
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string|null The string representation of the object or null
     * @throws Exception Returning other type than string or null
     */
    public function serialize(): string
    {
        return $this->uuid->serialize();
    }

    /**
     * Constructs the object.
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $data The string representation of the object.
     * @return void
     */
    public function unserialize($serialized): void
    {
        $this->uuid->unserialize($serialized);
    }

    public function jsonSerialize(): mixed
    {
        return $this->uuid->jsonSerialize();
    }

    /**
     * @deprecated This method will be removed in 5.0.0. There is no alternative
     *     recommendation, so plan accordingly.
     */
    public function getNumberConverter(): NumberConverterInterface
    {
        return $this->uuid->getNumberConverter();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance.
     *
     * @return mixed[]
     */
    public function getFieldsHex(): array
    {
        return $this->uuid->getFieldsHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getClockSeqHiAndReserved()}.
     */
    public function getClockSeqHiAndReservedHex(): string
    {
        return $this->uuid->getClockSeqHiAndReservedHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getClockSeqLow()}.
     */
    public function getClockSeqLowHex(): string
    {
        return $this->uuid->getClockSeqLowHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getClockSeq()}.
     */
    public function getClockSequenceHex(): string
    {
        return $this->uuid->getClockSequenceHex();
    }

    /**
     * @deprecated In ramsey/uuid version 5.0.0, this will be removed from the
     *     interface. It is available at {@see UuidV1::getDateTime()}.
     */
    public function getDateTime(): \DateTimeInterface
    {
        return $this->uuid->getDateTime();
    }

    /**
     * @deprecated This method will be removed in 5.0.0. There is no direct
     *     alternative, but the same information may be obtained by splitting
     *     in half the value returned by {@see UuidInterface::getHex()}.
     */
    public function getLeastSignificantBitsHex(): string
    {
        return $this->uuid->getLeastSignificantBitsHex();
    }

    /**
     * @deprecated This method will be removed in 5.0.0. There is no direct
     *     alternative, but the same information may be obtained by splitting
     *     in half the value returned by {@see UuidInterface::getHex()}.
     */
    public function getMostSignificantBitsHex(): string
    {
        return $this->uuid->getMostSignificantBitsHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getNode()}.
     */
    public function getNodeHex(): string
    {
        return $this->uuid->getNodeHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getTimeHiAndVersion()}.
     */
    public function getTimeHiAndVersionHex(): string
    {
        return $this->uuid->getTimeHiAndVersionHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getTimeLow()}.
     */
    public function getTimeLowHex(): string
    {
        return $this->uuid->getTimeLowHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getTimeMid()}.
     */
    public function getTimeMidHex(): string
    {
        return $this->uuid->getTimeMidHex();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getTimestamp()}.
     */
    public function getTimestampHex(): string
    {
        return $this->uuid->getTimestampHex();
    }

    /**
     * @deprecated In ramsey/uuid version 5.0.0, this will be removed from this
     *     interface. It has moved to {@see \Ramsey\Uuid\Rfc4122\UuidInterface::getUrn()}.
     */
    public function getUrn(): string
    {
        return $this->uuid->getUrn();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getVariant()}.
     */
    public function getVariant(): ?int
    {
        return $this->uuid->getVariant();
    }

    /**
     * @deprecated Use {@see UuidInterface::getFields()} to get a
     *     {@see FieldsInterface} instance. If it is a
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface} instance, you may call
     *     {@see \Ramsey\Uuid\Rfc4122\FieldsInterface::getVersion()}.
     */
    public function getVersion(): ?int
    {
        return $this->uuid->getVersion();
    }
}
