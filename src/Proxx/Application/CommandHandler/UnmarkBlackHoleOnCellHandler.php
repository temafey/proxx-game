<?php
declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use Micro\Game\Proxx\Domain\Command\UnmarkBlackHoleOnCellCommand;
use Micro\Game\Proxx\Domain\Entity\BoardEntity;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class UnmarkBlackHoleOnCellHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class UnmarkBlackHoleOnCellHandler implements CommandHandlerInterface
{
    /**
     * EntityStoreRepository object.
     */
    protected EntityStoreRepositoryInterface $entityStoreRepository;

    /**
     * Constructor
     */
    public function __construct(EntityStoreRepositoryInterface $entityStoreRepository)
    {
        $this->entityStoreRepository = $entityStoreRepository;
    }

    /**
     * Handle MarkBlackHoleOnCellCommand command.
     *
     * @var CommandInterface|UnmarkBlackHoleOnCellCommand.
     */
    public function handle(CommandInterface $unmarkBlackHoleOnCellCommand): BoardEntityInterface
    {
        /** @var BoardEntity $boardEntity */
        $boardEntity = $this->entityStoreRepository->get($unmarkBlackHoleOnCellCommand->getUuid());
        $boardEntity->markBlackHole(
            $unmarkBlackHoleOnCellCommand->getProcessUuid(),
            $unmarkBlackHoleOnCellCommand->getPositionX(),
            $unmarkBlackHoleOnCellCommand->getPositionY()
        );
        $this->entityStoreRepository->store($boardEntity);

        return $boardEntity;
    }
}

