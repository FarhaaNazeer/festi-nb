<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526203930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create all entities for the project';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE address ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN address.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4E6F81D17F50A6 ON address (uuid)');
        $this->addSql('ALTER TABLE festival ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN festival.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57CF789D17F50A6 ON festival (uuid)');
        $this->addSql('ALTER TABLE pass ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN pass.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE70D424D17F50A6 ON pass (uuid)');
        $this->addSql('ALTER TABLE photo ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN photo.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14B78418D17F50A6 ON photo (uuid)');
        $this->addSql('ALTER TABLE reservation ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN reservation.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955D17F50A6 ON reservation (uuid)');
        $this->addSql('ALTER TABLE ticket ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN ticket.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA3D17F50A6 ON ticket (uuid)');
        $this->addSql('ALTER TABLE "user" ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON "user" (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_57CF789D17F50A6');
        $this->addSql('ALTER TABLE festival DROP uuid');
        $this->addSql('DROP INDEX UNIQ_CE70D424D17F50A6');
        $this->addSql('ALTER TABLE pass DROP uuid');
        $this->addSql('DROP INDEX UNIQ_42C84955D17F50A6');
        $this->addSql('ALTER TABLE reservation DROP uuid');
        $this->addSql('DROP INDEX UNIQ_14B78418D17F50A6');
        $this->addSql('ALTER TABLE photo DROP uuid');
        $this->addSql('DROP INDEX UNIQ_97A0ADA3D17F50A6');
        $this->addSql('ALTER TABLE ticket DROP uuid');
        $this->addSql('DROP INDEX UNIQ_D4E6F81D17F50A6');
        $this->addSql('ALTER TABLE address DROP uuid');
        $this->addSql('DROP INDEX UNIQ_8D93D649D17F50A6');
        $this->addSql('ALTER TABLE "user" DROP uuid');
    }
}
