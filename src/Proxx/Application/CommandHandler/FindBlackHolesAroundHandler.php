<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\FindBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class FindBlackHolesAroundHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class FindBlackHolesAroundHandler implements CommandHandlerInterface
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
     * Handle FindBlackHolesAroundCommand command.
	 *
	 * @var CommandInterface|FindBlackHolesAroundCommand.
     */
    public function handle(CommandInterface $findBlackHolesAroundCommand): void
    {
		$boardEntity = $this->entityFactory->createInstance($findBlackHolesAroundCommand->getProcessUuid(), $findBlackHolesAroundCommand->getUuid());
		$this->entityStoreRepository->store($boardEntity);

    }
}
