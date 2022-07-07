<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707202929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding more fields to Ticket entity & Setup the relationship between Festival & Ticket';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD aartists TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_97A0ADA38AEBAF57 ON ticket (festival_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ticket DROP title');
        $this->addSql('ALTER TABLE ticket DROP start_date');
        $this->addSql('ALTER TABLE ticket DROP end_date');
        $this->addSql('ALTER TABLE ticket DROP description');
        $this->addSql('ALTER TABLE ticket DROP aartists');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA38AEBAF57');
        $this->addSql('DROP INDEX IDX_97A0ADA38AEBAF57');
        $this->addSql('ALTER TABLE ticket DROP festival_id');
    }
}
