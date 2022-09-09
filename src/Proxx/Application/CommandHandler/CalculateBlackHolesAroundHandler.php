<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\CalculateBlackHolesAroundCommand;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class CalculateBlackHolesAroundHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class CalculateBlackHolesAroundHandler implements CommandHandlerInterface
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
     * Handle CalculateBlackHolesAroundCommand command.
	 *
	 * @var CommandInterface|CalculateBlackHolesAroundCommand.
     */
    public function handle(CommandInterface $calculateBlackHolesAroundCommand): void
    {
		$boardEntity = $this->entityStoreRepository->get($calculateBlackHolesAroundCommand->getUuid());
		$boardEntity->calculateBlackHolesAround($calculateBlackHolesAroundCommand->getProcessUuid());
		$this->entityStoreRepository->store($boardEntity);
    }
}
