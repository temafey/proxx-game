<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Factory;

use Exception;
use MicroModule\ValueObject\DateTime\Exception\InvalidDateException;
use MicroModule\Common\Domain\ValueObject\CreatedAt;
use MicroModule\Common\Domain\ValueObject\FindCriteria;
use MicroModule\Common\Domain\ValueObject\Flag\Deleted;
use MicroModule\Common\Domain\ValueObject\Id;
use MicroModule\Common\Domain\ValueObject\NullValue;
use MicroModule\Common\Domain\ValueObject\Payload;
use MicroModule\Common\Domain\ValueObject\ProcessUuid;
use MicroModule\Common\Domain\ValueObject\Translation\Language;
use MicroModule\Common\Domain\ValueObject\UpdatedAt;
use MicroModule\Common\Domain\ValueObject\Uuid;

class CommonValueObjectFactory implements CommonValueObjectFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function makeProcessUuid(?string $processUuid = null): ProcessUuid
    {
        return ProcessUuid::fromNative($processUuid);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function makeUuid(?string $uuid = null): Uuid
    {
        return Uuid::fromNative($uuid);
    }

    /**
     * {@inheritdoc}
     */
    public function makeId(int $id): Id
    {
        return Id::fromNative($id);
    }

    /**
     * {@inheritdoc}
     */
    public function makeFindCriteria(array $criteria): FindCriteria
    {
        return FindCriteria::fromNative($criteria);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidDateException
     */
    public function makeCreatedAt(string $createdAt): CreatedAt
    {
        return CreatedAt::fromNative($createdAt);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidDateException
     */
    public function makeUpdatedAt(string $updatedAt): UpdatedAt
    {
        return UpdatedAt::fromNative($updatedAt);
    }

    /**
     * {@inheritdoc}
     */
    public function makeNullValue(): NullValue
    {
        return NullValue::create();
    }

    /**
     * {@inheritdoc}
     */
    public function makeDeletedFlag(int $deleted): Deleted
    {
        return Deleted::fromNative($deleted);
    }

    /**
     * {@inheritdoc}
     */
    public function makeLanguage(string $language): Language
    {
        return Language::fromNative($language);
    }

    /**
     * {@inheritdoc}
     */
    public function makePayload(array $payload): Payload
    {
        return Payload::fromNative($payload);
    }
}
