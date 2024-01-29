<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219195543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE techcare_brand (id UUID NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_brand.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_brand.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_brand.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_client (id UUID NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, billing_address VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_client.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_company (id UUID NOT NULL, name VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_company.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_component (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_component.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_invoice (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_invoice.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_product (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, release_year VARCHAR(4) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_product.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_product_category (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_product_category.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE techcare_quotation (id UUID NOT NULL, quotation_number VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, discount NUMERIC(10, 2) DEFAULT NULL, final_amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, water_damage BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_quotation.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_quotation_content (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_by VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, discount NUMERIC(10, 2) DEFAULT NULL, final_amount NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE techcare_brand');
        $this->addSql('DROP TABLE techcare_client');
        $this->addSql('DROP TABLE techcare_company');
        $this->addSql('DROP TABLE techcare_component');
        $this->addSql('DROP TABLE techcare_invoice');
        $this->addSql('DROP TABLE techcare_product');
        $this->addSql('DROP TABLE techcare_product_category');
        $this->addSql('DROP TABLE techcare_quotation');
        $this->addSql('DROP TABLE techcare_quotation_content');
    }
}
