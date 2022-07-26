<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726084627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD stripe_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD brand_stripe VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD last4_stripe VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD id_charge_stripe VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD stripe_status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD stripe_charge_price VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cart DROP stripe_token');
        $this->addSql('ALTER TABLE cart DROP brand_stripe');
        $this->addSql('ALTER TABLE cart DROP last4_stripe');
        $this->addSql('ALTER TABLE cart DROP id_charge_stripe');
        $this->addSql('ALTER TABLE cart DROP stripe_status');
        $this->addSql('ALTER TABLE cart DROP stripe_charge_price');
    }
}
