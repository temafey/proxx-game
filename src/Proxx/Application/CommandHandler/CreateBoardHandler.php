<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\CreateBoardCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class CreateBoardHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class CreateBoardHandler implements CommandHandlerInterface
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
     * Handle CreateBoardCommand command.
	 *
	 * @var CommandInterface|CreateBoardCommand.
     */
    public function handle(CommandInterface $createBoardCommand): void
    {
		$boardEntity = $this->entityFactory->createInstance($createBoardCommand->getProcessUuid(), $createBoardCommand->getUuid(), $createBoardCommand->getBoard());
		$this->entityStoreRepository->store($boardEntity);

    }
}
