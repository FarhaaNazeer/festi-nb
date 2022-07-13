<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711092717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE festival_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pass_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, user_address_id INT DEFAULT NULL, uuid UUID NOT NULL, street VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, is_default BOOLEAN DEFAULT NULL, is_enable BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4E6F81D17F50A6 ON address (uuid)');
        $this->addSql('CREATE INDEX IDX_D4E6F8152D06999 ON address (user_address_id)');
        $this->addSql('COMMENT ON COLUMN address.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE festival (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, begin_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, uuid UUID NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57CF789D17F50A6 ON festival (uuid)');
        $this->addSql('COMMENT ON COLUMN festival.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE festival_user (festival_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(festival_id, user_id))');
        $this->addSql('CREATE INDEX IDX_576D3FDE8AEBAF57 ON festival_user (festival_id)');
        $this->addSql('CREATE INDEX IDX_576D3FDEA76ED395 ON festival_user (user_id)');
        $this->addSql('CREATE TABLE pass (id INT NOT NULL, festival_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, short_description VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE70D424D17F50A6 ON pass (uuid)');
        $this->addSql('CREATE INDEX IDX_CE70D4248AEBAF57 ON pass (festival_id)');
        $this->addSql('COMMENT ON COLUMN pass.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE photo (id INT NOT NULL, filename VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14B78418D17F50A6 ON photo (uuid)');
        $this->addSql('COMMENT ON COLUMN photo.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, user_reservation_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, payment_method VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955D17F50A6 ON reservation (uuid)');
        $this->addSql('CREATE INDEX IDX_42C84955D3B748BE ON reservation (user_reservation_id)');
        $this->addSql('COMMENT ON COLUMN reservation.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, reservation_id INT DEFAULT NULL, festival_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, is_expired BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description TEXT DEFAULT NULL, artists TEXT DEFAULT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA3D17F50A6 ON ticket (uuid)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B83297E7 ON ticket (reservation_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38AEBAF57 ON ticket (festival_id)');
        $this->addSql('COMMENT ON COLUMN ticket.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, is_verified BOOLEAN NOT NULL, google_id VARCHAR(255) DEFAULT NULL, host_domain VARCHAR(255) DEFAULT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON "user" (uuid)');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8152D06999 FOREIGN KEY (user_address_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDE8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDEA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D4248AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D3B748BE FOREIGN KEY (user_reservation_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE festival_user DROP CONSTRAINT FK_576D3FDE8AEBAF57');
        $this->addSql('ALTER TABLE pass DROP CONSTRAINT FK_CE70D4248AEBAF57');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA38AEBAF57');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3B83297E7');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F8152D06999');
        $this->addSql('ALTER TABLE festival_user DROP CONSTRAINT FK_576D3FDEA76ED395');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955D3B748BE');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE festival_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pass_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE festival');
        $this->addSql('DROP TABLE festival_user');
        $this->addSql('DROP TABLE pass');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE "user"');
    }
}
