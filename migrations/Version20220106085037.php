<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106085037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie ADD letter_id INT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A93344525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id)');
        $this->addSql('CREATE INDEX IDX_AA3A93344525FF26 ON serie (letter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A93344525FF26');
        $this->addSql('DROP INDEX IDX_AA3A93344525FF26 ON serie');
        $this->addSql('ALTER TABLE serie DROP letter_id');
    }
}
