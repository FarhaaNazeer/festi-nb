<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710103908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Delete table Reservation and relationship between Festival & User";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP TABLE festival_user');
        $this->addSql('DROP TABLE reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE festival_user (festival_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(festival_id, user_id))');
        $this->addSql('CREATE INDEX idx_576d3fde8aebaf57 ON festival_user (festival_id)');
        $this->addSql('CREATE INDEX idx_576d3fdea76ed395 ON festival_user (user_id)');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, user_reservation_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, payment_method VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, uuid UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_42c84955d17f50a6 ON reservation (uuid)');
        $this->addSql('CREATE INDEX idx_42c84955d3b748be ON reservation (user_reservation_id)');
        $this->addSql('COMMENT ON COLUMN reservation.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT fk_576d3fde8aebaf57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT fk_576d3fdea76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c84955d3b748be FOREIGN KEY (user_reservation_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
