<?php

declare(strict_types=1);

namespace MicroModule\Common\Presentation\Rpc;

use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

/**
 * Health check class
 */
class PingMethod implements JsonRpcMethodInterface
{
    /**
     * {@inheritdoc}
     *
     * @suppress PhanUnusedPublicMethodParameter
     */
    public function apply(?array $paramList = null)
    {
        return 'pong';
    }
}
