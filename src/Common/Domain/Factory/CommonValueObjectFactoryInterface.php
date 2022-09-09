<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Factory;

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

interface CommonValueObjectFactoryInterface
{
    /**
     * Create Process Uuid value object
     */
    public function makeProcessUuid(?string $processUuid = null): ProcessUuid;

    /**
     * Create Uuid value object
     */
    public function makeUuid(?string $uuid = null): Uuid;

    /**
     * Create Id value object
     */
    public function makeId(int $id): Id;

    /**
     * Create FindCriteria value object
     */
    public function makeFindCriteria(array $criteria): FindCriteria;

    /**
     * Create CreatedAt value object
     */
    public function makeCreatedAt(?string $createdAt = null): CreatedAt;

    /**
     * Create UpdatedAt value object
     */
    public function makeUpdatedAt(?string $updatedAt = null): UpdatedAt;

    /**
     * Create NullValue value object
     */
    public function makeNullValue(): NullValue;

    /**
     * Create deleted value object
     */
    public function makeDeletedFlag(int $deleted): Deleted;

    /**
     * Create Language value object
     */
    public function makeLanguage(string $language): Language;

    /**
     * Create Payload value object
     */
    public function makePayload(array $payload): Payload;
}
