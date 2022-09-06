<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Processor;

use MicroModule\EventQueue\Application\EventHandling\QueueEventProcessor as BaseQueueEventProcessor;

class QueueEventProcessor extends BaseQueueEventProcessor
{
    /**
     * @return string
     */
    public static function getTopic(): string
    {
        return 'micro.game.proxx.queueevent';
    }
}
