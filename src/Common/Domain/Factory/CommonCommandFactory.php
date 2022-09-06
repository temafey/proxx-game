<?php

declare(strict_types=1);

namespace MicroModule\Common\Domain\Factory;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Base\Domain\Factory\CommandFactoryInterface as BaseCommandFactoryInterface;
use MicroModule\Common\Domain\Exception\CommandFactoryNotFoundException;

class CommonCommandFactory implements BaseCommandFactoryInterface
{
    /**
     * Available Command factories
     *
     * @var array<CommandFactoryInterface>
     */
    protected array $factories;

    /**
     * {@inheritdoc}
     */
    public function makeCommandInstanceByType(...$args): CommandInterface
    {
        $commandType = (string)$args[array_key_first($args)];
        $factory = $this->getFactoryByCommandType($commandType);

        return $factory->makeCommandInstanceByType(...$args);
    }

    public function addFactory(CommandFactoryInterface $commandFactory): self
    {
        $this->factories[$commandFactory::class] = $commandFactory;

        return $this;
    }

    protected function getFactoryByCommandType(string $commandType): CommandFactoryInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->isCommandAllowed($commandType)) {
                return $factory;
            }
        }

        throw CommandFactoryNotFoundException::fromCommandType($commandType);
    }
}
