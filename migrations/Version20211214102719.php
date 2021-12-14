<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214102719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE endpoint (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C4420F7BE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter_word (letter_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_44404A0B4525FF26 (letter_id), INDEX IDX_44404A0BE357438D (word_id), PRIMARY KEY(letter_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mute_letter (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3FBECEFEE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, school_level VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, definition LONGTEXT DEFAULT NULL, audio VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE endpoint ADD CONSTRAINT FK_C4420F7BE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0B4525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0BE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mute_letter ADD CONSTRAINT FK_3FBECEFEE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE letter_word DROP FOREIGN KEY FK_44404A0B4525FF26');
        $this->addSql('ALTER TABLE endpoint DROP FOREIGN KEY FK_C4420F7BE357438D');
        $this->addSql('ALTER TABLE letter_word DROP FOREIGN KEY FK_44404A0BE357438D');
        $this->addSql('ALTER TABLE mute_letter DROP FOREIGN KEY FK_3FBECEFEE357438D');
        $this->addSql('DROP TABLE endpoint');
        $this->addSql('DROP TABLE letter');
        $this->addSql('DROP TABLE letter_word');
        $this->addSql('DROP TABLE mute_letter');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE word');
    }
}
