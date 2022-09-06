<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\SetCellsCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class SetCellsHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class SetCellsHandler implements CommandHandlerInterface
{
    /**
     * EntityStoreRepository object.
     */
    protected EntityStoreRepositoryInterface $entityStoreRepository;

    /**
     * EntityFactory object.
     */
    protected EntityFactoryInterface $entityFactory;

    /**
     * Constructor
     */
    public function __construct(EntityStoreRepositoryInterface $entityStoreRepository, EntityFactoryInterface $entityFactory)
    {
		$this->entityStoreRepository = $entityStoreRepository;
		$this->entityFactory = $entityFactory;
        
    }

    /**
     * Handle SetCellsCommand command.
	 *
	 * @var CommandInterface|SetCellsCommand.
     */
    public function handle(CommandInterface $setCellsCommand): void
    {
		$boardEntity = $this->entityFactory->createInstance($setCellsCommand->getProcessUuid(), $setCellsCommand->getUuid());
		$this->entityStoreRepository->store($boardEntity);

    }
}
