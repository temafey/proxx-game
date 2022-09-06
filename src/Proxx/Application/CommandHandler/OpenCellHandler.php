<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\OpenCellCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class OpenCellHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class OpenCellHandler implements CommandHandlerInterface
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
     * Handle OpenCellCommand command.
	 *
	 * @var CommandInterface|OpenCellCommand.
     */
    public function handle(CommandInterface $openCellCommand): void
    {
		$boardEntity = $this->entityFactory->createInstance($openCellCommand->getProcessUuid(), $openCellCommand->getUuid(), $openCellCommand->getPositionX(), $openCellCommand->getPositionY());
		$this->entityStoreRepository->store($boardEntity);

    }
}
