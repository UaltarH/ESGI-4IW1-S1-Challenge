<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208105718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quotation_counter (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE techcare_brand (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_brand.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_brand.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_brand.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_client (id UUID NOT NULL, user_id UUID NOT NULL, billing_address VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DCBC1759A76ED395 ON techcare_client (user_id)');
        $this->addSql('COMMENT ON COLUMN techcare_client.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_client.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_company (id UUID NOT NULL, owner_id UUID DEFAULT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, siret VARCHAR(14) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4612BD777E3C61F9 ON techcare_company (owner_id)');
        $this->addSql('COMMENT ON COLUMN techcare_company.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_company.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_company.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_company.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_component (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_component.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_component_techcare_product (techcare_component_id UUID NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_component_id, techcare_product_id))');
        $this->addSql('CREATE INDEX IDX_7E5A9C2E188F00F ON techcare_component_techcare_product (techcare_component_id)');
        $this->addSql('CREATE INDEX IDX_7E5A9C247326692 ON techcare_component_techcare_product (techcare_product_id)');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_invoice (id UUID NOT NULL, quotation_id UUID NOT NULL, client_id UUID NOT NULL, payment_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, invoice_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_99C8A37CB4EA4E60 ON techcare_invoice (quotation_id)');
        $this->addSql('CREATE INDEX IDX_99C8A37C19EB6921 ON techcare_invoice (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99C8A37C4C3A3BB ON techcare_invoice (payment_id)');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.quotation_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.payment_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_payment (id UUID NOT NULL, client_id UUID NOT NULL, quotation_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount NUMERIC(10, 2) NOT NULL, method VARCHAR(255) NOT NULL, payment_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6485303519EB6921 ON techcare_payment (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64853035B4EA4E60 ON techcare_payment (quotation_id)');
        $this->addSql('COMMENT ON COLUMN techcare_payment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_payment.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_payment.quotation_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_product (id UUID NOT NULL, brand_id UUID DEFAULT NULL, product_category_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, release_year VARCHAR(4) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DAE7B09544F5D008 ON techcare_product (brand_id)');
        $this->addSql('CREATE INDEX IDX_DAE7B095BE6903FD ON techcare_product (product_category_id)');
        $this->addSql('COMMENT ON COLUMN techcare_product.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.brand_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.product_category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_product_category (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_quotation (id UUID NOT NULL, client_id UUID NOT NULL, quotation_number VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, discount NUMERIC(10, 2) DEFAULT NULL, final_amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, created_by VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9CD94F7A19EB6921 ON techcare_quotation (client_id)');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_quotation_content (id UUID NOT NULL, product_id UUID NOT NULL, quotation_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, discount NUMERIC(10, 2) DEFAULT NULL, final_amount NUMERIC(10, 2) NOT NULL, description VARCHAR(255) DEFAULT NULL, services JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2499DEEA4584665A ON techcare_quotation_content (product_id)');
        $this->addSql('CREATE INDEX IDX_2499DEEAB4EA4E60 ON techcare_quotation_content (quotation_id)');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.quotation_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_service (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_service.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_service.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_service.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_user (id UUID NOT NULL, company_id UUID DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_823BECD5E7927C74 ON techcare_user (email)');
        $this->addSql('CREATE INDEX IDX_823BECD5979B1AD6 ON techcare_user (company_id)');
        $this->addSql('COMMENT ON COLUMN techcare_user.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_user.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT FK_DCBC1759A76ED395 FOREIGN KEY (user_id) REFERENCES techcare_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_client ADD CONSTRAINT FK_DCBC1759BF396750 FOREIGN KEY (id) REFERENCES techcare_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_company ADD CONSTRAINT FK_4612BD777E3C61F9 FOREIGN KEY (owner_id) REFERENCES techcare_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C2E188F00F FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C247326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_invoice ADD CONSTRAINT FK_99C8A37CB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES techcare_quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_invoice ADD CONSTRAINT FK_99C8A37C19EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_invoice ADD CONSTRAINT FK_99C8A37C4C3A3BB FOREIGN KEY (payment_id) REFERENCES techcare_payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_payment ADD CONSTRAINT FK_6485303519EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_payment ADD CONSTRAINT FK_64853035B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES techcare_quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product ADD CONSTRAINT FK_DAE7B09544F5D008 FOREIGN KEY (brand_id) REFERENCES techcare_brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product ADD CONSTRAINT FK_DAE7B095BE6903FD FOREIGN KEY (product_category_id) REFERENCES techcare_product_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_quotation ADD CONSTRAINT FK_9CD94F7A19EB6921 FOREIGN KEY (client_id) REFERENCES techcare_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEA4584665A FOREIGN KEY (product_id) REFERENCES techcare_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEAB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES techcare_quotation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_user ADD CONSTRAINT FK_823BECD5979B1AD6 FOREIGN KEY (company_id) REFERENCES techcare_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT FK_DCBC1759A76ED395');
        $this->addSql('ALTER TABLE techcare_client DROP CONSTRAINT FK_DCBC1759BF396750');
        $this->addSql('ALTER TABLE techcare_company DROP CONSTRAINT FK_4612BD777E3C61F9');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C2E188F00F');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C247326692');
        $this->addSql('ALTER TABLE techcare_invoice DROP CONSTRAINT FK_99C8A37CB4EA4E60');
        $this->addSql('ALTER TABLE techcare_invoice DROP CONSTRAINT FK_99C8A37C19EB6921');
        $this->addSql('ALTER TABLE techcare_invoice DROP CONSTRAINT FK_99C8A37C4C3A3BB');
        $this->addSql('ALTER TABLE techcare_payment DROP CONSTRAINT FK_6485303519EB6921');
        $this->addSql('ALTER TABLE techcare_payment DROP CONSTRAINT FK_64853035B4EA4E60');
        $this->addSql('ALTER TABLE techcare_product DROP CONSTRAINT FK_DAE7B09544F5D008');
        $this->addSql('ALTER TABLE techcare_product DROP CONSTRAINT FK_DAE7B095BE6903FD');
        $this->addSql('ALTER TABLE techcare_quotation DROP CONSTRAINT FK_9CD94F7A19EB6921');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEA4584665A');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEAB4EA4E60');
        $this->addSql('ALTER TABLE techcare_user DROP CONSTRAINT FK_823BECD5979B1AD6');
        $this->addSql('DROP TABLE quotation_counter');
        $this->addSql('DROP TABLE techcare_brand');
        $this->addSql('DROP TABLE techcare_client');
        $this->addSql('DROP TABLE techcare_company');
        $this->addSql('DROP TABLE techcare_component');
        $this->addSql('DROP TABLE techcare_component_techcare_product');
        $this->addSql('DROP TABLE techcare_invoice');
        $this->addSql('DROP TABLE techcare_payment');
        $this->addSql('DROP TABLE techcare_product');
        $this->addSql('DROP TABLE techcare_product_category');
        $this->addSql('DROP TABLE techcare_quotation');
        $this->addSql('DROP TABLE techcare_quotation_content');
        $this->addSql('DROP TABLE techcare_service');
        $this->addSql('DROP TABLE techcare_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
