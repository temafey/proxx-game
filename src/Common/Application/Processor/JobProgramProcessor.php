<?php

declare(strict_types=1);

namespace MicroModule\Common\Application\Processor;

use MicroModule\Task\Application\Processor\JobCommandBusProcessor;

/**
 * Class JobProgramProcessor.
 */
class JobProgramProcessor extends JobCommandBusProcessor
{
    /**
     * @return string
     */
    public static function getRoute(): string
    {
        return 'task.command.run';
    }
}
