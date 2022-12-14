<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\MarkBlackHoleOnCellCommand;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class MarkBlackHoleOnCellHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class MarkBlackHoleOnCellHandler implements CommandHandlerInterface
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
     * @var CommandInterface|MarkBlackHoleOnCellCommand.
     */
    public function handle(CommandInterface $markBlackHoleOnCellCommand): BoardEntityInterface
    {
        $boardEntity = $this->entityStoreRepository->get($markBlackHoleOnCellCommand->getUuid());
        $boardEntity->markBlackHoleOnCell($markBlackHoleOnCellCommand->getProcessUuid(), $markBlackHoleOnCellCommand->getPositionX(), $markBlackHoleOnCellCommand->getPositionY());
        $this->entityStoreRepository->store($boardEntity);

        return $boardEntity;
    }
}
