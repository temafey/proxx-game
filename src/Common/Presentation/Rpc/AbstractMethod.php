<?php

declare(strict_types=1);

namespace MicroModule\Common\Presentation\Rpc;

use League\Tactician\CommandBus;
use MicroModule\Common\Domain\Dto\DtoInterface;
use Symfony\Component\Validator\Constraint;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

abstract class AbstractMethod implements
    JsonRpcMethodInterface,
    MethodWithValidatedParamsInterface,
    JsonRpcMethodWithDocInterface
{
    protected const KEY_PROCESS_UUID = 'process_uuid';
    protected const KEY_UUID = DtoInterface::KEY_UUID;
    protected const KEY_VERSION = DtoInterface::KEY_VERSION;

    protected CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public abstract function getParamsConstraint(): Constraint;

    /**
     * {@inheritdoc}
     */
    public abstract function apply(?array $paramList = null);

    /**
     * Get name of RPC method
     */
    protected abstract function getRpcMethodName(): string;

    /**
     * {@inheritdoc}
     */
    public function getDocTag(): string
    {
        return 'main';
    }
}
