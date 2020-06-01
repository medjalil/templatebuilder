<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601063714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachment ADD mustache_id INT NOT NULL');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB9E88594F FOREIGN KEY (mustache_id) REFERENCES mustache (id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB9E88594F ON attachment (mustache_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB9E88594F');
        $this->addSql('DROP INDEX IDX_795FD9BB9E88594F ON attachment');
        $this->addSql('ALTER TABLE attachment DROP mustache_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
