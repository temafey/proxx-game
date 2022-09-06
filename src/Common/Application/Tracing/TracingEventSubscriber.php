<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Tracing;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class TracingEventSubscriber implements EventSubscriberInterface, TraceableInterface
{
    use TracingTrait;

    /**
     * Return list of subscribed events.
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'flush',
        ];
    }

    /**
     * Flush events in tracer adapter.
     */
    public function flush(): void
    {
        $this->flushTrace();
    }
}
