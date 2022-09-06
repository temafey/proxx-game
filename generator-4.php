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
                "set-cells",
                "set-black-holes",
                "find-black-holes-around",
                "open-cell",
                "mark-black-hole",
            ],
            "cell" => [
                "create-cell",
                "set-black-hole",
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
                    "board",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "board-create" => [
                        "process_uuid",
                        "uuid",
                        "board",
                    ],
                ],
            ],
            "set-cells" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "cells-set" => [
                        "process_uuid",
                        "uuid",
                        "board",
                    ],
                ],
            ],
            "set-black-holes" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-holes-set" => [
                        "process_uuid",
                        "uuid",
                        "board",
                    ],
                ],
            ],
            "find-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "around-black-holes-found" => [
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
                    "board-create" => [
                        "process_uuid",
                        "uuid",
                        "position-x",
                        "position-y",
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
                    "cell-create" => [
                        "process_uuid",
                        "position-x",
                        "position-y",
                    ],
                ],
            ],
            "set-black-hole" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-hole-set" => [
                        "process_uuid",
                    ],
                ],
            ],
            "open" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "open" => [
                        "process_uuid",
                    ],
                ],
            ],
            "set-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                    "number-of-black-holes-around",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-holes-around-set" => [
                        "process_uuid",
                        "number-of-black-holes-around",
                    ],
                ],
            ],
            "mark-black-hole" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    "process_uuid",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "cell",
                DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                    "black-hole-mark" => [
                        "process_uuid",
                    ],
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
            "set-cells" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "set-black-holes" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "find-black-holes-around" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "open-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
                ],
                DataTypeInterface::STRUCTURE_TYPE_ENTITY => "board",
            ],
            "mark-black-hole-on-cell" => [
                DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                    DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'entity-store',
                    DataTypeInterface::STRUCTURE_TYPE_FACTORY => "entity",
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
                    "board-create" => true,
                    "cells-set" => true,
                    "black-holes-set" => true,
                    "around-black-holes-found" => true,
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
