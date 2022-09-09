<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\InstallCellsCommand;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class InstallCellsHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class InstallCellsHandler implements CommandHandlerInterface
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
     * Handle SetCellsCommand command.
	 *
	 * @var CommandInterface|InstallCellsCommand.
     */
    public function handle(CommandInterface $installCellsCommand): void
    {
		$boardEntity = $this->entityStoreRepository->get($installCellsCommand->getUuid());
		$boardEntity->installCells($installCellsCommand->getProcessUuid());
		$this->entityStoreRepository->store($boardEntity);
    }
}
