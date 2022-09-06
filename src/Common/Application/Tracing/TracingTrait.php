<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Tracing;

use OpenTracing\Reference;
use OpenTracing\Scope;
use OpenTracing\Span;
use OpenTracing\Tracer;

/**
 * Trait TracingTrait.
 */
trait TracingTrait
{
    /**
     * Is tracing enabled flag.
     */
    protected bool $isTracingEnabled = false;

    /**
     * OpenTracing adapter.
     */
    protected ?Tracer $tracer = null;

    /**
     * Helper, that help send correct trace logs to tracer adapter.
     */
    protected ?TracingHelperInterface $tracingHelper = null;

    /**
     * Set OpenTracing adapter.
     */
    public function setTracer(Tracer $tracer): void
    {
        $this->tracer = $tracer;
        $this->tracingHelper = new TracingHelper();
    }

    /**
     * Set tracing flag.
     */
    public function setIsTracingEnabled(bool $isTracingEnabled): void
    {
        $this->isTracingEnabled = $isTracingEnabled;
    }

    /**
     * Starts current active `Span` representing a unit of work.
     */
    protected function startTracingActiveSpan(string $operation, array $options = []): ?Scope
    {
        if (
            null === $this->tracer ||
            null === $this->tracingHelper ||
            !$this->isTracingEnabled
        ) {
            return null;
        }

        [$operation, $options] = $this->tracingHelper->processSpanOptions($this::class, $operation, $options);

        return $this->tracer->startActiveSpan($operation, $options);
    }

    /**
     * Starts and returns a new `Span` representing a unit of work.
     */
    protected function startTracingSpan(string $operation, array $options = []): ?Span
    {
        if (
            null === $this->tracer ||
            null === $this->tracingHelper ||
            !$this->isTracingEnabled
        ) {
            return null;
        }

        if (!isset($options[Reference::CHILD_OF])) {
            $options[Reference::CHILD_OF] = $this->tracer->getActiveSpan();
        }
        [$operation, $options] = $this->tracingHelper->processSpanOptions($this::class, $operation, $options);

        return $this->tracer->startSpan($operation, $options);
    }

    /**
     * Sets the end timestamp and finalizes Span state.
     */
    protected function finishTraceSpan(Scope|Span|null $span): void
    {
        if (null === $span) {
            return;
        }

        if ($span instanceof Scope) {
            $span->close();

            return;
        }

        $span->finish();
    }

    /**
     * Allow tracer adapter to send span data to be instrumented.
     */
    protected function flushTrace(): void
    {
        if (null === $this->tracer || !$this->isTracingEnabled) {
            return;
        }

        $this->tracer->flush();
    }
}
