<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\SetBlackHolesCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class SetBlackHolesHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class SetBlackHolesHandler implements CommandHandlerInterface
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
     * Handle SetBlackHolesCommand command.
	 *
	 * @var CommandInterface|SetBlackHolesCommand.
     */
    public function handle(CommandInterface $setBlackHolesCommand): void
    {
		$boardEntity = $this->entityFactory->createInstance($setBlackHolesCommand->getProcessUuid(), $setBlackHolesCommand->getUuid());
		$this->entityStoreRepository->store($boardEntity);

    }
}
