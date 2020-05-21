<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518032251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE environment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mustache (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, name VARCHAR(255) NOT NULL, function LONGTEXT NOT NULL, INDEX IDX_488F3D88903E3A94 (environment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, mustache_id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_939F45449E88594F (mustache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mustache ADD CONSTRAINT FK_488F3D88903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45449E88594F FOREIGN KEY (mustache_id) REFERENCES mustache (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mustache DROP FOREIGN KEY FK_488F3D88903E3A94');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45449E88594F');
        $this->addSql('DROP TABLE environment');
        $this->addSql('DROP TABLE mustache');
        $this->addSql('DROP TABLE ressource');
    }
}
