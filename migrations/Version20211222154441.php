<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222154441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word ADD serie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_C3F17511D94388BD ON word (serie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511D94388BD');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP INDEX IDX_C3F17511D94388BD ON word');
        $this->addSql('ALTER TABLE word DROP serie_id');
    }
}
