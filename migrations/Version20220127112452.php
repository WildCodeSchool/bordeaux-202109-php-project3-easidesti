<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127112452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_school_level (user_id INT NOT NULL, school_level_id INT NOT NULL, INDEX IDX_C4DC060BA76ED395 (user_id), INDEX IDX_C4DC060BA1F77FE3 (school_level_id), PRIMARY KEY(user_id, school_level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_school_level ADD CONSTRAINT FK_C4DC060BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_school_level ADD CONSTRAINT FK_C4DC060BA1F77FE3 FOREIGN KEY (school_level_id) REFERENCES school_level (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_school_level');
    }
}
