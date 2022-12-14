<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\CalculateBlackHolesAroundCommand;
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
     * Constructor
     */
    public function __construct(EntityStoreRepositoryInterface $entityStoreRepository)
    {
		$this->entityStoreRepository = $entityStoreRepository;
        
    }

    /**
     * Handle FindBlackHolesAroundCommand command.
	 *
	 * @var CommandInterface|CalculateBlackHolesAroundCommand.
     */
    public function handle(CommandInterface $findBlackHolesAroundCommand): void
    {
		$boardEntity = $this->entityStoreRepository->get($findBlackHolesAroundCommand->getUuid());
		$boardEntity->findBlackHolesAround($findBlackHolesAroundCommand->getProcessUuid());
		$this->entityStoreRepository->store($boardEntity);
    }
}
