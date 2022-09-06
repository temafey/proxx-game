<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Service;

use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class MappingCollector implements MappingCollectorInterface
{
    /**
     * @var array<JsonRpcMethodInterface>
     */
    protected array $mappingList = [];

    /**
     * {@inheritdoc}
     */
    public function addJsonRpcMethod(string $methodName, JsonRpcMethodInterface $method): void
    {
        $this->mappingList[$methodName] = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getMappingList(): array
    {
        return $this->mappingList;
    }
}
