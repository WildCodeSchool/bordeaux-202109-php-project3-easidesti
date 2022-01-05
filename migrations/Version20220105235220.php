<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105235220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE endpoint (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C4420F7BE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, serie_id INT NOT NULL, is_easi TINYINT(1) NOT NULL, step INT NOT NULL, error_count INT DEFAULT NULL, help_count INT DEFAULT NULL, score INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, error_step INT NOT NULL, INDEX IDX_232B318C99E6F5DF (player_id), INDEX IDX_232B318CD94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(1) NOT NULL, nb_proposal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mute_letter (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3FBECEFEE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pronunciation (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, number INT NOT NULL, level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, school_level VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, letter_id INT DEFAULT NULL, serie_id INT DEFAULT NULL, pronunciation_id INT NOT NULL, content VARCHAR(255) NOT NULL, definition LONGTEXT DEFAULT NULL, audio VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_C3F175114525FF26 (letter_id), INDEX IDX_C3F17511D94388BD (serie_id), INDEX IDX_C3F17511B506CB17 (pronunciation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE endpoint ADD CONSTRAINT FK_C4420F7BE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE mute_letter ADD CONSTRAINT FK_3FBECEFEE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F175114525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511B506CB17 FOREIGN KEY (pronunciation_id) REFERENCES pronunciation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F175114525FF26');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511B506CB17');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD94388BD');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511D94388BD');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C99E6F5DF');
        $this->addSql('ALTER TABLE endpoint DROP FOREIGN KEY FK_C4420F7BE357438D');
        $this->addSql('ALTER TABLE mute_letter DROP FOREIGN KEY FK_3FBECEFEE357438D');
        $this->addSql('DROP TABLE endpoint');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE letter');
        $this->addSql('DROP TABLE mute_letter');
        $this->addSql('DROP TABLE pronunciation');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE word');
    }
}
