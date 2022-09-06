<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Tracing;

use League\Tactician\Exception\CanNotInvokeHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Middleware;
use OpenTracing\Scope;
use Throwable;

/**
 * Class TracerMiddleware, CommandBus middleware.
 */
class TracerMiddleware implements Middleware
{
    use TracingTrait;

    protected HandlerLocator $handlerLocator;

    protected MethodNameInflector $methodNameInflector;

    /**
     * Constructor.
     */
    public function __construct(
        HandlerLocator $handlerLocator,
        MethodNameInflector $methodNameInflector
    ) {
        $this->handlerLocator = $handlerLocator;
        $this->methodNameInflector = $methodNameInflector;
    }

    /**
     * Executes a command and optionally returns a value.
     *
     * @param object $command
     *
     * @return mixed
     *
     * @throws CanNotInvokeHandlerException
     * @throws Throwable
     *
     * @psalm-suppress PossiblyNullReference
     */
    public function execute($command, callable $next)
    {
        $scope = $this->startTrace($command);

        try {
            $returnValue = $next($command);
        } catch (Throwable $e) {
            if ($scope) {
                $this->tracingHelper
                    ->addTag($scope, 'command_failed', $command::class)
                    ->addLog($scope, 'message', $e->getMessage())
                    ->addLog($scope, 'trace', $e->getTraceAsString());
                $this->finishTraceSpan($scope);
            }

            throw $e;
        }
        $this->finishTraceSpan($scope);

        return $returnValue;
    }

    /**
     * Start tracing.
     *
     * @param object $command
     */
    protected function startTrace($command): ?Scope
    {
        if (null === $this->tracingHelper || null === $this->tracer) {
            return null;
        }
        $handler = $this->handlerLocator->getHandlerForCommand($command::class);
        $methodName = $this->methodNameInflector->inflect($command, $handler);
        $scope = $this->startTracingActiveSpan(
            sprintf('%s_%s', $this->tracingHelper->getShortClassName($handler::class), $methodName),
            [TracingHelperInterface::KEY_OPTIONS_ADD_CLASSNAME_TO_OPERATION => false]
        );
        $this->tracingHelper
            ->addTag($scope, TracingHelperInterface::KEY_COMPONENT_TAG, TracingHelperInterface::KEY_COMPONENT_COMMAND_BUS)
            ->addTag($scope, TracingHelperInterface::KEY_COMMAND_TAG, $command::class);

        return $scope;
    }
}
