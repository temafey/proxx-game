<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use Micro\Game\Proxx\Domain\Entity\BoardEntityInterface;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\OpenCellCommand;
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
     * Constructor
     */
    public function __construct(EntityStoreRepositoryInterface $entityStoreRepository)
    {
		$this->entityStoreRepository = $entityStoreRepository;
        
    }

    /**
     * Handle OpenCellCommand command.
	 *
	 * @var CommandInterface|OpenCellCommand.
     */
    public function handle(CommandInterface $openCellCommand): BoardEntityInterface
    {
		$boardEntity = $this->entityStoreRepository->get($openCellCommand->getUuid());
		$boardEntity->openCell($openCellCommand->getProcessUuid(), $openCellCommand->getPositionX(), $openCellCommand->getPositionY());
		$this->entityStoreRepository->store($boardEntity);

        return $boardEntity;
    }
}
