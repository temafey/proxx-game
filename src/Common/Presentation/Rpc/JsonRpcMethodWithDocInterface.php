<?php

declare(strict_types=1);

namespace MicroModule\Common\Presentation\Rpc;

use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;

interface JsonRpcMethodWithDocInterface
{
    /**
     * Return TypeDoc object
     */
    public function getDocResponse(): TypeDoc;

    /**
     * Return array of error ErrorDoc
     *
     * @return ErrorDoc[]
     */
    public function getDocErrors(): array;

    /**
     * Return rpc method description
     */
    public function getDocDescription(): string;

    /**
     * Return rpc method tag
     */
    public function getDocTag(): string;
}
