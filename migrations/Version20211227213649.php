<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227213649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word ADD pronunciation_id INT NOT NULL');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511B506CB17 FOREIGN KEY (pronunciation_id) REFERENCES pronunciation (id)');
        $this->addSql('CREATE INDEX IDX_C3F17511B506CB17 ON word (pronunciation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511B506CB17');
        $this->addSql('DROP INDEX IDX_C3F17511B506CB17 ON word');
        $this->addSql('ALTER TABLE word DROP pronunciation_id');
    }
}
