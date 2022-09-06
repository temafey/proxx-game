<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Presentation\Cli\Command;

use League\Tactician\CommandBus;
use Micro\Game\Proxx\Domain\Factory\CommandFactoryInterface;
use MicroModule\Common\Domain\ValueObject\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * Class GameCommand.
 *
 * @SuppressWarnings(PHPMD)
 */
#[AsCommand(name: "game:start")]
class GameCommand extends Command
{
    protected const NAME = "game:start";
    protected const DESCRIPTION = "Start Proxx game";

    public function __construct(
        protected CommandBus $commandBus,
        protected CommandFactoryInterface $commandFactory,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Starting <comment>Proxx game</comment>... ");
        $helper = $this->getHelper("question");
        $question = new Question("Please enter the width of board", 5);
        $boardWidth = $helper->ask($input, $output, $question);
        $question = new Question("Please enter number of black holes", 5);
        $numberOfBlackHoles = $helper->ask($input, $output, $question);

        // Start a workflow execution. Usually this is done from another program.
        // Uses task queue from the GreetingWorkflow @WorkflowMethod annotation.
        try {
            $uuid = (string) (new Uuid());
            $command = $this->commandFactory->makeCommandInstanceByType(
                CommandFactoryInterface::CREATE_BOARD_COMMAND,
                $uuid,
                $boardWidth,
                $numberOfBlackHoles
            );
            $this->commandBus->handle($command);
        } catch (Throwable $e) {
            $output->writeln("Process stopped unsuccessfully");
            throw $e;
            return 1;
        }

        return self::SUCCESS;
    }
}
