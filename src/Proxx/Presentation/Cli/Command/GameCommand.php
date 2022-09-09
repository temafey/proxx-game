<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Presentation\Cli\Command;

use League\Tactician\CommandBus;
use Micro\Game\Proxx\Domain\Entity\BoardEntity;
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
    protected $helper;

    public function __construct(
        protected CommandBus $commandBus,
        protected CommandFactoryInterface $commandFactory,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->helper = $this->getHelper("question");
        $output->writeln("Starting <comment>Proxx game</comment>... ");
        $question = new Question("Please enter the width of board: ", 5);
        $boardWidth = (int) $this->helper->ask($input, $output, $question);
        $question = new Question("Please enter number of black holes: ", 5);
        $numberOfBlackHoles = (int) $this->helper->ask($input, $output, $question);

        // Start a workflow execution. Usually this is done from another program.
        // Uses task queue from the GreetingWorkflow @WorkflowMethod annotation.
        try {
            $uuid = (string) (new Uuid());
            $command = $this->commandFactory->makeCommandInstanceByType(
                CommandFactoryInterface::CREATE_BOARD_COMMAND,
                $uuid,
                $uuid,
                $boardWidth,
                $numberOfBlackHoles
            );
            $this->commandBus->handle($command);

            while (true) {
                $question = new Question("Please choose action (o: open cell, m: mark black hole, u: unmark black hole): ");
                $action = $this->helper->ask($input, $output, $question);

                switch ($action) {
                    case "o":
                        $status = $this->actionOpenCell($input, $output, $uuid);
                        break;
                    case "m":
                        $status = $this->actionMarkCell($input, $output, $uuid);
                        break;
                    case "u":
                        $status = $this->actionUnmarkCell($input, $output, $uuid);
                        break;
                    default:
                        $output->writeln(sprintf("Action '%s' incorrect!", $action));
                        $status = 1;
                        break;
                }

                if ($status === 1) {
                    break;
                }
            }
        } catch (Throwable $e) {
            $output->writeln("Process stopped unsuccessfully");
            throw $e;
            return 1;
        }

        return self::SUCCESS;
    }

    protected function actionOpenCell(InputInterface $input, OutputInterface $output, string $uuid): int
    {
        $question = new Question("Please enter position x and y to open cell: ");
        [$posX, $posY] = explode(" ", $this->helper->ask($input, $output, $question));
        $output->writeln(sprintf("You choose %s %s", $posX, $posY));
        $command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::OPEN_CELL_COMMAND, $uuid, $uuid, (int)$posX, (int)$posY);
        /** @var BoardEntity $boardEntity */
        $boardEntity = $this->commandBus->handle($command);

        if (!$boardEntity->getGameStatus()->isGameInProgress()) {
            if ($boardEntity->getGameStatus()->isGameFinishSuccessfully()) {
                $output->writeln("Game finish successfully!");
            } else {
                $output->writeln("Game finish unsuccessfully");
            }

            return 1;
        }

        return 0;
    }

    protected function actionMarkCell(InputInterface $input, OutputInterface $output, string $uuid): int
    {
        $question = new Question("Please enter position x and y to mark cell: ");
        [$posX, $posY] = explode(" ", $this->helper->ask($input, $output, $question));
        $command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::MARK_BLACK_HOLE_COMMAND, $uuid, $uuid, (int)$posX, (int)$posY);
        /** @var BoardEntity $boardEntity */
        $boardEntity = $this->commandBus->handle($command);

        if ($boardEntity->getGameStatus()->isGameFinishSuccessfully()) {
            $output->writeln("Game finish successfully!");

            return 1;
        }

        return 0;
    }

    protected function actionUnmarkCell(InputInterface $input, OutputInterface $output, string $uuid): int
    {
        $question = new Question("Please enter position x and y to unmark cell: ");
        [$posX, $posY] = explode(" ", $this->helper->ask($input, $output, $question));
        $command = $this->commandFactory->makeCommandInstanceByType(CommandFactoryInterface::UNMARK_BLACK_HOLE_COMMAND, $uuid, $uuid, (int)$posX, (int)$posY);
        $this->commandBus->handle($command);

        return 0;
    }
}
