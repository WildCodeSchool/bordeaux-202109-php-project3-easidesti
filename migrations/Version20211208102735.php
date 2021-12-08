<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208102735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE end_point (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, endpoint_position INT NOT NULL, INDEX IDX_C63AB421E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter_word (letter_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_44404A0B4525FF26 (letter_id), INDEX IDX_44404A0BE357438D (word_id), PRIMARY KEY(letter_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mute_letter (id INT AUTO_INCREMENT NOT NULL, word_id INT NOT NULL, letter_position INT DEFAULT NULL, INDEX IDX_3FBECEFEE357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, end_point_id INT NOT NULL, content VARCHAR(255) NOT NULL, definition LONGTEXT NOT NULL, audio VARCHAR(255) NOT NULL, INDEX IDX_C3F17511196B5B2F (end_point_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE end_point ADD CONSTRAINT FK_C63AB421E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0B4525FF26 FOREIGN KEY (letter_id) REFERENCES letter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE letter_word ADD CONSTRAINT FK_44404A0BE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mute_letter ADD CONSTRAINT FK_3FBECEFEE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511196B5B2F FOREIGN KEY (end_point_id) REFERENCES end_point (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511196B5B2F');
        $this->addSql('ALTER TABLE letter_word DROP FOREIGN KEY FK_44404A0B4525FF26');
        $this->addSql('ALTER TABLE end_point DROP FOREIGN KEY FK_C63AB421E357438D');
        $this->addSql('ALTER TABLE letter_word DROP FOREIGN KEY FK_44404A0BE357438D');
        $this->addSql('ALTER TABLE mute_letter DROP FOREIGN KEY FK_3FBECEFEE357438D');
        $this->addSql('DROP TABLE end_point');
        $this->addSql('DROP TABLE letter');
        $this->addSql('DROP TABLE letter_word');
        $this->addSql('DROP TABLE mute_letter');
        $this->addSql('DROP TABLE word');
    }
}
