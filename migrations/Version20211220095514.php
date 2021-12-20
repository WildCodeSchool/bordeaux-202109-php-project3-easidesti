<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220095514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE letter_word');
        $this->addSql('ALTER TABLE word ADD letter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F175114525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id)');
        $this->addSql('CREATE INDEX IDX_C3F175114525FF26 ON word (letter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE letter_word (letter_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_44404A0B4525FF26 (letter_id), INDEX IDX_44404A0BE357438D (word_id), PRIMARY KEY(letter_id, word_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0B4525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0BE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F175114525FF26');
        $this->addSql('DROP INDEX IDX_C3F175114525FF26 ON word');
        $this->addSql('ALTER TABLE word DROP letter_id');
    }
}
