<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105223528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_letter');
        $this->addSql('DROP TABLE game_word');
        $this->addSql('ALTER TABLE game CHANGE serie_id serie_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_letter (game_id INT NOT NULL, letter_id INT NOT NULL, INDEX IDX_F33743C24525FF26 (letter_id), INDEX IDX_F33743C2E48FD905 (game_id), PRIMARY KEY(game_id, letter_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game_word (game_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_28E4193DE357438D (word_id), INDEX IDX_28E4193DE48FD905 (game_id), PRIMARY KEY(game_id, word_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_letter ADD CONSTRAINT FK_F33743C24525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_letter ADD CONSTRAINT FK_F33743C2E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_word ADD CONSTRAINT FK_28E4193DE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_word ADD CONSTRAINT FK_28E4193DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game CHANGE serie_id serie_id INT DEFAULT NULL');
    }
}
