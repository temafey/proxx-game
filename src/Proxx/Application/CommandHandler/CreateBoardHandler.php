<?php

declare(strict_types=1);

namespace Micro\Game\Proxx\Application\CommandHandler;

use Micro\Game\Proxx\Domain\Factory\ValueObjectFactoryInterface;
use Micro\Game\Proxx\Domain\ValueObject\GameStatus;
use MicroModule\Base\Domain\Command\CommandInterface;
use MicroModule\Common\Application\CommandHandler\CommandHandlerInterface;
use Micro\Game\Proxx\Domain\Command\CreateBoardCommand;
use Micro\Game\Proxx\Domain\Factory\EntityFactoryInterface;
use Micro\Game\Proxx\Domain\Repository\EntityStoreRepositoryInterface;
use MicroModule\Common\Domain\Factory\CommonValueObjectFactoryInterface;

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
     * ValueObjectFactory object.
     */
    protected ValueObjectFactoryInterface|CommonValueObjectFactoryInterface $valueObjectFactory;

    /**
     * EntityFactory object.
     */
    protected EntityFactoryInterface $entityFactory;

    /**
     * Constructor
     */
    public function __construct(
        EntityStoreRepositoryInterface $entityStoreRepository,
        ValueObjectFactoryInterface|CommonValueObjectFactoryInterface $valueObjectFactory,
        EntityFactoryInterface $entityFactory,
    ){
		$this->entityStoreRepository = $entityStoreRepository;
        $this->valueObjectFactory = $valueObjectFactory;
		$this->entityFactory = $entityFactory;
    }

    /**
     * Handle CreateBoardCommand command.
	 *
	 * @var CommandInterface|CreateBoardCommand.
     */
    public function handle(CommandInterface $createBoardCommand): void
    {
        $boardValueObject = $this->valueObjectFactory->makeBoard([
            "width" => $createBoardCommand->getWidth()->toNative(),
            "number-of-black-holes" => $createBoardCommand->getNumberOfBlackHoles()->toNative(),
            "number-of-opened-cells" => 0,
            "number-of-marked-black-holes" => 0,
            "game-status" => GameStatus::GAME_IN_PROGRESS,
            "created_at" => date("Y-m-d H:i:s"),
        ]);
		$boardEntity = $this->entityFactory->createInstance($createBoardCommand->getProcessUuid(), $createBoardCommand->getUuid(), $boardValueObject);
		$this->entityStoreRepository->store($boardEntity);
    }
}
