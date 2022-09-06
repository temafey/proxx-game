<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Tracing;

use DateTimeInterface;
use OpenTracing\Scope;
use OpenTracing\Span;

/**
 * Class TracingHelper.
 */
class TracingHelper implements TracingHelperInterface
{
    /**
     * Adds a tag to the span.
     */
    public function addTag(Span|Scope|null $span, string $key, string $value): self
    {
        if (null === $span) {
            return $this;
        }

        if ($span instanceof Scope) {
            $span = $span->getSpan();
        }
        $span->setTag($key, $value);

        return $this;
    }

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
    ): self {
        if (null === $span) {
            return $this;
        }

        if ($span instanceof Scope) {
            $span = $span->getSpan();
        }

        $span->log([$key => $value], $timestamp);

        return $this;
    }

    /**
     * Generate and return list of span options.
     *
     * @return mixed[]
     */
    public function processSpanOptions(string $calledClassName, string $operation, array $options): array
    {
        if (!isset($options[self::KEY_OPTIONS_ADD_CLASSNAME_TO_OPERATION])
            || false !== $options[self::KEY_OPTIONS_ADD_CLASSNAME_TO_OPERATION]
        ) {
            $operation = sprintf('%s_%s', $this->getShortClassName($calledClassName), $operation);
        }
        unset($options[self::KEY_OPTIONS_ADD_CLASSNAME_TO_OPERATION]);

        return [$operation, $options];
    }

    /**
     * Generate and return short name of class.
     */
    public function getShortClassName(string $fullClassDefinition): string
    {
        return substr(strrchr($fullClassDefinition, '\\'), 1);
    }
}
