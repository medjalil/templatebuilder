<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517140502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE environment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE mustache (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, environment_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, function CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_488F3D88903E3A94 ON mustache (environment_id)');
        $this->addSql('CREATE TABLE ressource (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, environment_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_939F4544903E3A94 ON ressource (environment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE environment');
        $this->addSql('DROP TABLE mustache');
        $this->addSql('DROP TABLE ressource');
    }
}
