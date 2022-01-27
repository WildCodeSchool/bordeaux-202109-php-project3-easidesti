<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127111711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE school_level ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE school_level ADD CONSTRAINT FK_44107A09C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_44107A09C32A47EE ON school_level (school_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE school_level DROP FOREIGN KEY FK_44107A09C32A47EE');
        $this->addSql('DROP INDEX IDX_44107A09C32A47EE ON school_level');
        $this->addSql('ALTER TABLE school_level DROP school_id');
    }
}
