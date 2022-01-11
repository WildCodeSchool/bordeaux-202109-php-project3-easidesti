<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111145515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE study_letter (id INT AUTO_INCREMENT NOT NULL, position INT NOT NULL, audio VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word ADD study_letter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511D1E24DB7 FOREIGN KEY (study_letter_id) REFERENCES study_letter (id)');
        $this->addSql('CREATE INDEX IDX_C3F17511D1E24DB7 ON word (study_letter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511D1E24DB7');
        $this->addSql('DROP TABLE study_letter');
        $this->addSql('DROP INDEX IDX_C3F17511D1E24DB7 ON word');
        $this->addSql('ALTER TABLE word DROP study_letter_id');
    }
}
