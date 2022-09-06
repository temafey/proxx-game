<?php

declare(strict_types=1);

namespace MicroModule\Common\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version20211130103817 extends AbstractMigration implements ContainerAwareInterface
{
    protected EntityManager $em;

    /**
     * Events store table name.
     */
    protected string $tableName = 'events';

    protected bool $useBinary = false;

    /**
     * Migration description.
     */
    public function getDescription(): string
    {
        return 'Create table `events`';
    }

    public function up(Schema $schema): void
    {
        $this->configureSchema($schema);
        $this->em->flush();
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
        $this->em->flush();
    }

    public function setContainer(?ContainerInterface $container = null): void
    {
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function configureSchema(Schema $schema): ?Table
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    public function configureTable(?Schema $schema = null): Table
    {
        $schema = $schema ?: new Schema();

        $uuidColumnDefinition = [
            'type' => 'guid',
            'params' => [
                'length' => 36,
            ],
        ];

        if ($this->useBinary) {
            $uuidColumnDefinition['type'] = 'binary';
            $uuidColumnDefinition['params'] = [
                'length' => 16,
                'fixed' => true,
            ];
        }

        $table = $schema->createTable($this->tableName);

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('uuid', $uuidColumnDefinition['type'], $uuidColumnDefinition['params']);
        $table->addColumn('playhead', 'integer', ['unsigned' => true]);
        $table->addColumn('payload', 'text');
        $table->addColumn('metadata', 'text');
        $table->addColumn('recorded_on', 'datetime');
        $table->addColumn('type', 'string', ['length' => 255]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid', 'playhead']);

        return $table;
    }
}
