<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710100918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of Cart entity - Relationship between Ticket & Cart - Relationship between Cart & User';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, user_cart_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, payment_method VARCHAR(255) DEFAULT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7D17F50A6 ON cart (uuid)');
        $this->addSql('CREATE INDEX IDX_BA388B742D8D3B5 ON cart (user_cart_id)');
        $this->addSql('COMMENT ON COLUMN cart.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B742D8D3B5 FOREIGN KEY (user_cart_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT fk_97a0ada3b83297e7');
        $this->addSql('DROP INDEX idx_97a0ada3b83297e7');
        $this->addSql('ALTER TABLE ticket ALTER is_expired SET DEFAULT false');
        $this->addSql('ALTER TABLE ticket ALTER is_expired DROP NOT NULL');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN reservation_id TO cart_id');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA31AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_97A0ADA31AD5CDBF ON ticket (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA31AD5CDBF');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP INDEX IDX_97A0ADA31AD5CDBF');
        $this->addSql('ALTER TABLE ticket ALTER is_expired DROP DEFAULT');
        $this->addSql('ALTER TABLE ticket ALTER is_expired SET NOT NULL');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN cart_id TO reservation_id');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT fk_97a0ada3b83297e7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_97a0ada3b83297e7 ON ticket (reservation_id)');
    }
}
