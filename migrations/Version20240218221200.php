<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218221200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT fk_dcbc1759bf396750');
        $this->addSql('ALTER TABLE techcare_client ADD company_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD firstname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD lastname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD created_by VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD updated_by VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_client.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_client.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_client.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT FK_DCBC1759979B1AD6 FOREIGN KEY (company_id) REFERENCES techcare_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DCBC1759E7927C74 ON techcare_client (email)');
        $this->addSql('CREATE INDEX IDX_DCBC1759979B1AD6 ON techcare_client (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT FK_DCBC1759979B1AD6');
        $this->addSql('DROP INDEX UNIQ_DCBC1759E7927C74');
        $this->addSql('DROP INDEX IDX_DCBC1759979B1AD6');
        $this->addSql('ALTER TABLE techcare_client DROP company_id');
        $this->addSql('ALTER TABLE techcare_client DROP firstname');
        $this->addSql('ALTER TABLE techcare_client DROP lastname');
        $this->addSql('ALTER TABLE techcare_client DROP email');
        $this->addSql('ALTER TABLE techcare_client DROP created_by');
        $this->addSql('ALTER TABLE techcare_client DROP updated_by');
        $this->addSql('ALTER TABLE techcare_client DROP created_at');
        $this->addSql('ALTER TABLE techcare_client DROP updated_at');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT fk_dcbc1759bf396750 FOREIGN KEY (id) REFERENCES techcare_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
