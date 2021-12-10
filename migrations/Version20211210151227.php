<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210151227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511196B5B2F');
        $this->addSql('CREATE TABLE endpoint (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, position INT NOT NULL, INDEX IDX_C4420F7BE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE endpoint ADD CONSTRAINT FK_C4420F7BE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('DROP TABLE end_point');
        $this->addSql('DROP TABLE letter_word');
        $this->addSql('ALTER TABLE letter ADD word_id INT NOT NULL');
        $this->addSql('ALTER TABLE letter ADD CONSTRAINT FK_8E02EE0AE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('CREATE INDEX IDX_8E02EE0AE357438D ON letter (word_id)');
        $this->addSql('ALTER TABLE mute_letter ADD position INT NOT NULL, DROP letter_position, CHANGE word_id word_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_C3F17511196B5B2F ON word');
        $this->addSql('ALTER TABLE word DROP end_point_id, CHANGE definition definition LONGTEXT DEFAULT NULL, CHANGE audio audio VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE end_point (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, endpoint_position INT NOT NULL, INDEX IDX_C63AB421E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE letter_word (letter_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_44404A0B4525FF26 (letter_id), INDEX IDX_44404A0BE357438D (word_id), PRIMARY KEY(letter_id, word_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE end_point ADD CONSTRAINT FK_C63AB421E357438D FOREIGN KEY (word_id) REFERENCES word (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0B4525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0BE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE endpoint');
        $this->addSql('ALTER TABLE letter DROP FOREIGN KEY FK_8E02EE0AE357438D');
        $this->addSql('DROP INDEX IDX_8E02EE0AE357438D ON letter');
        $this->addSql('ALTER TABLE letter DROP word_id');
        $this->addSql('ALTER TABLE mute_letter ADD letter_position INT DEFAULT NULL, DROP position, CHANGE word_id word_id INT NOT NULL');
        $this->addSql('ALTER TABLE word ADD end_point_id INT NOT NULL, CHANGE definition definition LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE audio audio VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511196B5B2F FOREIGN KEY (end_point_id) REFERENCES end_point (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C3F17511196B5B2F ON word (end_point_id)');
    }
}
