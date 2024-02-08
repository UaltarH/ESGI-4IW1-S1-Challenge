<?php

declare(strict_types=1);

namespace bu;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120174726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE techcare_component_techcare_product (techcare_component_id UUID NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_component_id, techcare_product_id))');
        $this->addSql('CREATE INDEX IDX_7E5A9C2E188F00F ON techcare_component_techcare_product (techcare_component_id)');
        $this->addSql('CREATE INDEX IDX_7E5A9C247326692 ON techcare_component_techcare_product (techcare_product_id)');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_payment (id UUID NOT NULL, invoice_id UUID NOT NULL, client_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount NUMERIC(10, 2) NOT NULL, method VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_648530352989F1FD ON techcare_payment (invoice_id)');
        $this->addSql('CREATE INDEX IDX_6485303519EB6921 ON techcare_payment (client_id)');
        $this->addSql('COMMENT ON COLUMN techcare_payment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_payment.invoice_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_payment.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_service (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_service.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_service.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_service.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C2E188F00F FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C247326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_payment ADD CONSTRAINT FK_648530352989F1FD FOREIGN KEY (invoice_id) REFERENCES techcare_invoice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_payment ADD CONSTRAINT FK_6485303519EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_client ADD company_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_client ADD active BOOLEAN NOT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_client.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT FK_DCBC1759979B1AD6 FOREIGN KEY (company_id) REFERENCES techcare_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DCBC1759979B1AD6 ON techcare_client (company_id)');
        $this->addSql('ALTER TABLE techcare_invoice ADD quotation_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_invoice ADD client_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_invoice ADD invoice_number VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.quotation_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_invoice ADD CONSTRAINT FK_99C8A37CB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES techcare_quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_invoice ADD CONSTRAINT FK_99C8A37C19EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_99C8A37CB4EA4E60 ON techcare_invoice (quotation_id)');
        $this->addSql('CREATE INDEX IDX_99C8A37C19EB6921 ON techcare_invoice (client_id)');
        $this->addSql('ALTER TABLE techcare_product ADD brand_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_product ADD product_category_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_product.brand_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.product_category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_product ADD CONSTRAINT FK_DAE7B09544F5D008 FOREIGN KEY (brand_id) REFERENCES techcare_brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product ADD CONSTRAINT FK_DAE7B095BE6903FD FOREIGN KEY (product_category_id) REFERENCES techcare_product_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DAE7B09544F5D008 ON techcare_product (brand_id)');
        $this->addSql('CREATE INDEX IDX_DAE7B095BE6903FD ON techcare_product (product_category_id)');
        $this->addSql('ALTER TABLE techcare_quotation ADD client_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_quotation ADD CONSTRAINT FK_9CD94F7A19EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9CD94F7A19EB6921 ON techcare_quotation (client_id)');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD quotation_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD service_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.quotation_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.service_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEAB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES techcare_quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEAED5CA9E6 FOREIGN KEY (service_id) REFERENCES techcare_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2499DEEAB4EA4E60 ON techcare_quotation_content (quotation_id)');
        $this->addSql('CREATE INDEX IDX_2499DEEAED5CA9E6 ON techcare_quotation_content (service_id)');
        $this->addSql('ALTER TABLE techcare_user ADD company_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_user.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_user ADD CONSTRAINT FK_823BECD5979B1AD6 FOREIGN KEY (company_id) REFERENCES techcare_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_823BECD5979B1AD6 ON techcare_user (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEAED5CA9E6');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C2E188F00F');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C247326692');
        $this->addSql('ALTER TABLE techcare_payment DROP CONSTRAINT FK_648530352989F1FD');
        $this->addSql('ALTER TABLE techcare_payment DROP CONSTRAINT FK_6485303519EB6921');
        $this->addSql('DROP TABLE techcare_component_techcare_product');
        $this->addSql('DROP TABLE techcare_payment');
        $this->addSql('DROP TABLE techcare_service');
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT FK_DCBC1759979B1AD6');
        $this->addSql('DROP INDEX IDX_DCBC1759979B1AD6');
        $this->addSql('ALTER TABLE techcare_client DROP company_id');
        $this->addSql('ALTER TABLE techcare_client DROP active');
        $this->addSql('ALTER TABLE techcare_quotation DROP CONSTRAINT FK_9CD94F7A19EB6921');
        $this->addSql('DROP INDEX IDX_9CD94F7A19EB6921');
        $this->addSql('ALTER TABLE techcare_quotation DROP client_id');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEAB4EA4E60');
        $this->addSql('DROP INDEX IDX_2499DEEAB4EA4E60');
        $this->addSql('DROP INDEX IDX_2499DEEAED5CA9E6');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP quotation_id');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP service_id');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP description');
        $this->addSql('ALTER TABLE techcare_invoice DROP CONSTRAINT FK_99C8A37CB4EA4E60');
        $this->addSql('ALTER TABLE techcare_invoice DROP CONSTRAINT FK_99C8A37C19EB6921');
        $this->addSql('DROP INDEX IDX_99C8A37CB4EA4E60');
        $this->addSql('DROP INDEX IDX_99C8A37C19EB6921');
        $this->addSql('ALTER TABLE techcare_invoice DROP quotation_id');
        $this->addSql('ALTER TABLE techcare_invoice DROP client_id');
        $this->addSql('ALTER TABLE techcare_invoice DROP invoice_number');
        $this->addSql('ALTER TABLE techcare_product DROP CONSTRAINT FK_DAE7B09544F5D008');
        $this->addSql('ALTER TABLE techcare_product DROP CONSTRAINT FK_DAE7B095BE6903FD');
        $this->addSql('DROP INDEX IDX_DAE7B09544F5D008');
        $this->addSql('DROP INDEX IDX_DAE7B095BE6903FD');
        $this->addSql('ALTER TABLE techcare_product DROP brand_id');
        $this->addSql('ALTER TABLE techcare_product DROP product_category_id');
        $this->addSql('ALTER TABLE techcare_user DROP CONSTRAINT FK_823BECD5979B1AD6');
        $this->addSql('DROP INDEX IDX_823BECD5979B1AD6');
        $this->addSql('ALTER TABLE techcare_user DROP company_id');
    }
}
