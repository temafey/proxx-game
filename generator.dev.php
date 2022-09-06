<?php

use MicroModule\MicroserviceGenerator\Generator\DataTypeInterface;
use MicroModule\MicroserviceGenerator\Service\ProjectBuilder;

set_time_limit(0);

require 'vendor/autoload.php';

$structure = [
  'User' => [
      DataTypeInterface::STRUCTURE_TYPE_ENTITY => [
          'user' => [
              'register',
              'update',
              'delete',
              'block',
          ]
      ],

      DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT => [
          'process_uuid' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_IDENTITY_UUID,
          ],
          'uuid' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_IDENTITY_UUID,
          ],
          'nickname' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_STRING,
          ],
          'password' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_STRING,
          ],
          'name' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_PERSON_NAME,
          ],
          'age' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_PERSON_AGE,
          ],
          'status' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_NUMBER_INTEGER,
          ],
          'created_at' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_DATETIME_DATETIME,
          ],
          'updated_at' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_DATETIME_DATETIME,
          ],
          'user' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_ENTITY,
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'nickname',
                  'password',
                  'name',
                  'age',
                  'status',
                  'created_at',
                  'updated_at',
                  'status'
              ]
          ],
          'find_criteria' => [
              'type' => DataTypeInterface::VALUE_OBJECT_TYPE_STRUCTURE_DICTIONARY,
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_COMMAND => [
          'register' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'uuid',
                  'user',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'register' => [
                      'process_uuid',
                      'uuid',
                      'user',
                  ],
              ],
          ],
          'update' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'uuid',
                  'user',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'update' => [
                      'process_uuid',
                      'uuid',
                      'user',
                  ],
              ],
          ],
          'delete' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'uuid',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'delete' => [
                      'process_uuid',
                      'uuid',
                  ],
              ],
          ],
          'block' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'uuid',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'block' => [
                      'process_uuid',
                      'uuid',
                  ],
              ],
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_COMMAND_HANDLER => [
          'register' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'command',
                  DataTypeInterface::STRUCTURE_TYPE_FACTORY => 'user',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
          'update' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'command',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
          'delete' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'command',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
          'block' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'command',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_QUERY => [
          'fetch-one' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'uuid',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_QUERY_HANDLER => [
          'fetch-one' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'query',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_QUERY => [
          'find-all' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'process_uuid',
                  'find_criteria',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_QUERY_HANDLER => [
          'find-all' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => 'query',
              ],
              DataTypeInterface::STRUCTURE_TYPE_ENTITY => 'user',
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_SAGA => [
          'user' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'League\Tactician\CommandBus',
                  'MicroModule\Base\Domain\Factory\CommandFactoryInterface',
              ],
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'register' => 'update',
                  'update' => 'block',
                  'block' => 'delete',
                  'delete' => true
              ],
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_PROJECTOR => [
          'user' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'user' => DataTypeInterface::STRUCTURE_TYPE_REPOSITORY,
                  'command' => DataTypeInterface::STRUCTURE_TYPE_REPOSITORY,
                  'query' => DataTypeInterface::STRUCTURE_TYPE_REPOSITORY,
                  'League\Tactician\CommandBus',
                  'MicroModule\Base\Domain\Factory\CommandFactoryInterface',
              ],
              DataTypeInterface::STRUCTURE_TYPE_EVENT => [
                  'register',
                  'update',
                  'delete',
                  'block',
              ],
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_REPOSITORY => [
          'command' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'Poc\Micro\Skeleton\Domain\Repository\ReadModelStoreInterface',
              ],
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_METHODS => [
                  'add' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'user' => DataTypeInterface::STRUCTURE_TYPE_ENTITY,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_VOID,
                  ],
                  'update' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'user' => DataTypeInterface::STRUCTURE_TYPE_ENTITY,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_VOID,
                  ],
                  'delete' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'user' => DataTypeInterface::STRUCTURE_TYPE_ENTITY,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_VOID,
                  ],
              ]
          ],
          'query' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'Poc\Micro\Skeleton\Domain\Repository\ReadModelStoreInterface',
                  'Poc\Micro\Skeleton\Domain\Factory\UserFactory',
                  'Poc\Micro\Skeleton\Domain\Factory\ValueObjectFactory',
              ],
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_METHODS => [
                  'getAll' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'limit' => DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT,
                          'offset' => DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_ARRAY,
                  ],
                  'findByUuid' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'uuid' => DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_ARRAY,
                  ],
                  'findByCriteria' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'FindCriteria' => DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT,
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => DataTypeInterface::DATA_TYPE_ARRAY,
                  ],
                  'findByNickname' => [
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                          'nickname' => DataTypeInterface::STRUCTURE_TYPE_VALUE_OBJECT,
                          'Poc\Micro\Poc\User\Rpc\Domain\Entity\UserReadInterface',
                      ],
                      DataTypeInterface::BUILDER_STRUCTURE_TYPE_RETURN => 'Poc\Micro\Poc\User\Rpc\Domain\Entity\UserReadInterface',
                  ],
              ]
          ],
          'user-event-sourcing-store' => [
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_ARGS => [
                  'Broadway\EventStore\EventStore',
                  'Broadway\EventHandling\EventBus',
                  'eventStreamDecorators' => DataTypeInterface::DATA_TYPE_ARRAY,
              ],
              DataTypeInterface::BUILDER_STRUCTURE_TYPE_METHODS => [

              ]
          ],
      ],

      DataTypeInterface::STRUCTURE_TYPE_SERVICE => [
          'test' => [
              'func1' => [

              ],
              'func2' => [

              ],
              'func3' => [

              ],
              'func4' => [

              ],
          ],
      ],
  ]
];

$generatorProjectBuilder = new ProjectBuilder('/app/src', 'Poc\Micro\Skeleton', $structure);
$generatorProjectBuilder->generate();
