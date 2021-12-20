<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216113553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE letter_word (letter_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_44404A0B4525FF26 (letter_id), INDEX IDX_44404A0BE357438D (word_id), PRIMARY KEY(letter_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0B4525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0BE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter DROP FOREIGN KEY FK_8E02EE0AE357438D');
        $this->addSql('DROP INDEX IDX_8E02EE0AE357438D ON letter');
        $this->addSql('ALTER TABLE letter DROP word_id, DROP created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE letter_word');
        $this->addSql('ALTER TABLE letter ADD word_id INT NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE letter ADD CONSTRAINT FK_8E02EE0AE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8E02EE0AE357438D ON letter (word_id)');
    }
}
