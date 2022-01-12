<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112095107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, created_at DATETIME NOT NULL, step INT NOT NULL, error_count INT DEFAULT NULL, score INT NOT NULL, INDEX IDX_D5128A8F99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_word (training_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_CC6B3252BEFD98D1 (training_id), INDEX IDX_CC6B3252E357438D (word_id), PRIMARY KEY(training_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training_word ADD CONSTRAINT FK_CC6B3252BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_word ADD CONSTRAINT FK_CC6B3252E357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training_word DROP FOREIGN KEY FK_CC6B3252BEFD98D1');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_word');
    }
}
