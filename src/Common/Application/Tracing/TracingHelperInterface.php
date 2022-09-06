<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Tracing;

use DateTimeInterface;
use OpenTracing\Scope;
use OpenTracing\Span;

/**
 * Interface TracingHelperInterface.
 */
interface TracingHelperInterface
{
    public const KEY_PROCESS_UUID = 'process_uuid';
    public const KEY_COMPONENT_TAG = 'component';
    public const KEY_ENTITY_UUID = 'entity_uuid';
    public const KEY_COMMAND_TAG = 'command';

    public const KEY_COMPONENT_TASK = 'task';
    public const KEY_COMPONENT_COMMAND_BUS = 'command_bus';
    public const KEY_COMPONENT_EVENT_MODEL = 'event_model';
    public const KEY_COMPONENT_SAGA = 'saga';

    public const KEY_OPTIONS_ADD_CLASSNAME_TO_OPERATION = 'add_classname_to_operation';

    /**
     * Add tad to span.
     */
    public function addTag(Span|Scope|null $span, string $key, string $value): self;

    /**
     * Adds a log record to the span in key => value format, key must be a string and tag must be either
     * a string, a boolean value, or a numeric type.
     *
     * If the span is already finished, a warning should be logged.
     */
    public function addLog(
        Span|Scope|null $span,
        string $key,
        string $value,
        int|float|DateTimeInterface $timestamp = null
    ): self;

    /**
     * Generate and return list of span options.
     *
     * @param mixed[] $options
     *
     * @return mixed[]
     */
    public function processSpanOptions(string $calledClassName, string $operation, array $options): array;

    /**
     * Generate and return short name of class.
     */
    public function getShortClassName(string $fullClassDefinition): string;
}
