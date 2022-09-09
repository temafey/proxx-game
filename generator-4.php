<?php

use MicroModule\MicroserviceGenerator\Generator\DataTypeInterface;
use MicroModule\MicroserviceGenerator\Service\ProjectBuilder;

set_time_limit(0);

require "vendor/autoload.php";

$domainNamespace = "Micro\Game\Proxx";
$mainDomainName = "proxx";

$structure = [
    $mainDomainName => [
        DataTypeInterface::STRUCTURE_TYPE_ENTITY => [
            "board" => [
                "create-board",
                "install-cells",
                "place-black-holes",
                "calculate-black-holes-around",
                "open-cell",
                "mark-black-hole",
                "process-game",
            ],
            "cell" => [
                "create-cell",
                "place-black-hole",
                "open",
                "set-black-holes-around",
                "mark-black-hole",
            ]
        ],

        DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT => [
            "process_uuid" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_IDENTITY_UUID,
            ],
            "uuid" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_IDENTITY_UUID,
            ],
            "width" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "number-of-black-holes" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "cells" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_STRUCTURE_COLLECTION,
            ],
            "opened-cells" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_STRUCTURE_COLLECTION,
            ],
            "black-holes" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_STRUCTURE_COLLECTION,
            ],
            "number-of-cells" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "number-of-opened-cells" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "number-of-marked-black-holes" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "game-status" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],

            "position-x" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "position-y" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "has-black-hole" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "number-of-black-holes-around" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "was-opened" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "was-marked" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
            ],
            "created_at" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_DATETIME_DATETIME,
            ],
            "updated_at" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_DATETIME_DATETIME,
            ],
            "board" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_ENTITY,
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "width",
                    "number-of-black-holes",
                    "number-of-opened-cells",
                    "number-of-marked-black-holes",
                    "created_at",
                    "updated_at",
                ]
            ],
            "cell" => [
                "type" => DataTypeInterface::VALUE_OBJECT_TYPE_ENTITY,
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "position-x",
                    "position-y",
                    "has-black-hole",
                    "number-of-black-holes-around",
                    "was-opened",
                    "was-marked",
                    "created_at",
                    "updated_at",
                ]
            ],
        ],

        DataTypeInterface::STRUCTURE_TYPE_COMMAND => [
            "create-board" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                    "width",
                    "number-of-black-holes"
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "board-create" => [
                        "process_uuid",
                        "uuid",
                        "width",
                        "number-of-black-holes"
                    ],
                ],
            ],
            "install-cells" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "cells-install" => [
                        "process_uuid",
                        "uuid",
                        "cells",
                    ],
                ],
            ],
            "place-black-holes" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-holes-place" => [
                        "process_uuid",
                        "uuid",
                        "cells",
                    ],
                ],
            ],
            "calculate-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-holes-around-calculate" => [
                        "process_uuid",
                        "uuid",
                        "board",
                    ],
                ],
            ],
            "open-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                    "position-x",
                    "position-y",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "cell-open" => [
                        "process_uuid",
                        "uuid",
                        "position-x",
                        "position-y",
                    ],
                ],
            ],
            "mark-black-hole-on-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                    "position-x",
                    "position-y",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-hole-mark" => [
                        "process_uuid",
                        "uuid",
                        "position-x",
                        "position-y",
                    ],
                ],
            ],
            "process-game" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "game-process" => [
                        "process_uuid",
                        "uuid",
                    ],
                    "game-successful-finish" => [
                        "process_uuid",
                        "uuid",
                    ],
                    "game-unsuccessful-finish" => [
                        "process_uuid",
                        "uuid",
                    ],
                ],
            ],
            "create-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "position-x",
                    "position-y",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                ],
            ],
            "place-black-hole" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                ],
            ],
            "open" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                ],
            ],
            "set-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "number-of-black-holes-around",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [

                ],
            ],
            "mark-black-hole" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                ],
            ],
        ],

        DataTypeInterface::STRUCTURE_TYPE_COMMAND_HANDLER => [
            "create-board" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "install-cells" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "place-black-holes" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "calculate-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "open-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "mark-black-hole-on-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
        ],

        DataTypeInterface::STRUCTURE_TYPE_SAGA => [
            $mainDomainName => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "League\Tactician\CommandBus",
                    "Micro\Game\Domain\Factory\CommandFactoryInterface",
                ],
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "board-create" => "install-cells",
                    "cells-install" => "place-black-holes",
                    "black-holes-place" => "calculate-black-holes-around",
                    "black-holes-around-calculate" => "process-game",
                    "cell-open" => "process-game",
                    "black-hole-mark" => "process-game",
                    "game-successful-finish" => true,
                    "game-unsuccessful-finish" => true,
                ],
            ],
        ],

        DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => [
            "entity-store" => [
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "MicroModule\Common\Domain\Repository\ReadModelStoreInterface",
                ],
            ],
            "event-sourcing-store" => [
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_REPOSITORY_INTERFACE => false,
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "Broadway\EventStore\EventStore",
                    "Broadway\EventHandling\EventBus",
                    "eventStreamDecorators" => DataTypeInterface::DATA_TYPE_ARRAY,
                ],
            ],
        ],
    ],
];

$generatorProjectBuilder = new ProjectBuilder("/app/src", $domainNamespace, $structure);
$generatorProjectBuilder->generate();
