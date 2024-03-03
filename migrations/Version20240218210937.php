<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218210937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT fk_dcbc1759a76ed395');
        $this->addSql('DROP INDEX uniq_dcbc1759a76ed395');
        $this->addSql('ALTER TABLE techcare_client DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_client ADD user_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_client.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT fk_dcbc1759a76ed395 FOREIGN KEY (user_id) REFERENCES techcare_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_dcbc1759a76ed395 ON techcare_client (user_id)');
    }
}
