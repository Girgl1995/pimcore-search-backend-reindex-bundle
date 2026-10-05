<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261003200558 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'creates the search_backend_reindex table to record reindex requests and adds the bundle permission definition.';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE IF NOT EXISTS `search_backend_reindex` (
                `timestamp` bigint(20) DEFAULT NULL,
                `userOwner` int(10) NOT NULL,
                PRIMARY KEY (`timestamp`, `userOwner`)
            )
            COLLATE="utf8mb4_general_ci"
            ENGINE=InnoDB
            SQL);

        $this->addSql(<<<'SQL'
            INSERT INTO `users_permission_definitions` (`key`, `category`)
            VALUES ('search_backend_reindex', 'Search Backend Reindex Bundle')
            SQL);
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DELETE FROM `users_permission_definitions`
            WHERE `key` = 'search_backend_reindex'
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE IF EXISTS `search_backend_reindex`
            SQL);
    }
}
