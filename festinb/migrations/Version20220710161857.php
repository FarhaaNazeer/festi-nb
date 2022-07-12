<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710161857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating CartItem entity - Relationship between Cart & CartItem - Relationship between CartItem & Ticket';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE pass_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cart_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart_item (id INT NOT NULL, cart_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, item_price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0FE25271AD5CDBF ON cart_item (cart_id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527700047D2 ON cart_item (ticket_id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE pass');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT fk_97a0ada31ad5cdbf');
        $this->addSql('DROP INDEX idx_97a0ada31ad5cdbf');
        $this->addSql('ALTER TABLE ticket DROP cart_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cart_item_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pass_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pass (id INT NOT NULL, festival_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, short_description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, uuid UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_ce70d424d17f50a6 ON pass (uuid)');
        $this->addSql('CREATE INDEX idx_ce70d4248aebaf57 ON pass (festival_id)');
        $this->addSql('COMMENT ON COLUMN pass.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT fk_ce70d4248aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('ALTER TABLE ticket ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT fk_97a0ada31ad5cdbf FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_97a0ada31ad5cdbf ON ticket (cart_id)');
    }
}
