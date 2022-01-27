<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127160008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_school_level');
        $this->addSql('ALTER TABLE user ADD school_level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A1F77FE3 FOREIGN KEY (school_level_id) REFERENCES school_level (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A1F77FE3 ON user (school_level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_school_level (user_id INT NOT NULL, school_level_id INT NOT NULL, INDEX IDX_C4DC060BA1F77FE3 (school_level_id), INDEX IDX_C4DC060BA76ED395 (user_id), PRIMARY KEY(user_id, school_level_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_school_level ADD CONSTRAINT FK_C4DC060BA1F77FE3 FOREIGN KEY (school_level_id) REFERENCES school_level (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_school_level ADD CONSTRAINT FK_C4DC060BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A1F77FE3');
        $this->addSql('DROP INDEX IDX_8D93D649A1F77FE3 ON user');
        $this->addSql('ALTER TABLE user DROP school_level_id');
    }
}
