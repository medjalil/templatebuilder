<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517185804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_488F3D88903E3A94');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mustache AS SELECT id, environment_id, name, function FROM mustache');
        $this->addSql('DROP TABLE mustache');
        $this->addSql('CREATE TABLE mustache (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, environment_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, function CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_488F3D88903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mustache (id, environment_id, name, function) SELECT id, environment_id, name, function FROM __temp__mustache');
        $this->addSql('DROP TABLE __temp__mustache');
        $this->addSql('CREATE INDEX IDX_488F3D88903E3A94 ON mustache (environment_id)');
        $this->addSql('DROP INDEX IDX_939F4544903E3A94');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ressource AS SELECT id, environment_id, type, name, content FROM ressource');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('CREATE TABLE ressource (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mustache_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL COLLATE BINARY, name VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_939F45449E88594F FOREIGN KEY (mustache_id) REFERENCES mustache (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ressource (id, mustache_id, type, name, content) SELECT id, environment_id, type, name, content FROM __temp__ressource');
        $this->addSql('DROP TABLE __temp__ressource');
        $this->addSql('CREATE INDEX IDX_939F45449E88594F ON ressource (mustache_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_488F3D88903E3A94');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mustache AS SELECT id, environment_id, name, function FROM mustache');
        $this->addSql('DROP TABLE mustache');
        $this->addSql('CREATE TABLE mustache (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, environment_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, function CLOB NOT NULL)');
        $this->addSql('INSERT INTO mustache (id, environment_id, name, function) SELECT id, environment_id, name, function FROM __temp__mustache');
        $this->addSql('DROP TABLE __temp__mustache');
        $this->addSql('CREATE INDEX IDX_488F3D88903E3A94 ON mustache (environment_id)');
        $this->addSql('DROP INDEX IDX_939F45449E88594F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ressource AS SELECT id, mustache_id, type, name, content FROM ressource');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('CREATE TABLE ressource (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, content CLOB NOT NULL, environment_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO ressource (id, environment_id, type, name, content) SELECT id, mustache_id, type, name, content FROM __temp__ressource');
        $this->addSql('DROP TABLE __temp__ressource');
        $this->addSql('CREATE INDEX IDX_939F4544903E3A94 ON ressource (environment_id)');
    }
}
