<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711130534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE cart ALTER amount SET DEFAULT \'0\'');
        $this->addSql('ALTER TABLE cart_item ADD uuid UUID NOT NULL');
        $this->addSql('ALTER TABLE cart_item ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN cart_item.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0FE2527D17F50A6 ON cart_item (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cart DROP quantity');
        $this->addSql('ALTER TABLE cart ALTER amount DROP DEFAULT');
        $this->addSql('DROP INDEX UNIQ_F0FE2527D17F50A6');
        $this->addSql('ALTER TABLE cart_item DROP uuid');
        $this->addSql('ALTER TABLE cart_item DROP created_at');
        $this->addSql('ALTER TABLE cart_item DROP updated_at');
    }
}
