<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use Micro\Game\Proxx\Domain\Command\ProcessGameCommand;
use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;

/**
 * @class ProcessGameHandler
 *
 * @package Micro\Game\Proxx\Application\CommandHandler
 */
class ProcessGameHandler implements CommandHandlerInterface
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
     * Handle ProcessGameCommand command.
	 *
	 * @var CommandInterface|ProcessGameCommand.
     */
    public function handle(CommandInterface $processGameCommand): BoardEntityInterface
    {
		$boardEntity = $this->entityStoreRepository->get($processGameCommand->getUuid());
        $boardEntity->processGame($processGameCommand->getProcessUuid(), $processGameCommand->getPositionX(), $processGameCommand->getPositionY());
		$this->entityStoreRepository->store($boardEntity);

        return $boardEntity;
    }
}
