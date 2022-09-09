<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\PlaceBlackHolesCommand;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class PlaceBlackHolesHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class PlaceBlackHolesHandler implements CommandHandlerInterface
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
     * Handle PlaceBlackHolesCommand command.
	 *
	 * @var CommandInterface|PlaceBlackHolesCommand.
     */
    public function handle(CommandInterface $placeBlackHolesCommand): void
    {
		$boardEntity = $this->entityStoreRepository->get($placeBlackHolesCommand->getUuid());
		$boardEntity->setBlackHoles($placeBlackHolesCommand->getProcessUuid());
		$this->entityStoreRepository->store($boardEntity);

    }
}
