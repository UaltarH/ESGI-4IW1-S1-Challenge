<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226013701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE techcare_product_component_price_id_seq CASCADE');
        $this->addSql('CREATE TABLE techcare_component_techcare_product (techcare_component_id UUID NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_component_id, techcare_product_id))');
        $this->addSql('CREATE INDEX IDX_7E5A9C2E188F00F ON techcare_component_techcare_product (techcare_component_id)');
        $this->addSql('CREATE INDEX IDX_7E5A9C247326692 ON techcare_component_techcare_product (techcare_product_id)');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C2E188F00F FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT FK_7E5A9C247326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component DROP CONSTRAINT fk_9767e8b2d76b079c');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component DROP CONSTRAINT fk_9767e8b2e188f00f');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product DROP CONSTRAINT fk_67c501bd76b079c');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product DROP CONSTRAINT fk_67c501b47326692');
        $this->addSql('DROP TABLE techcare_product_component_price_techcare_component');
        $this->addSql('DROP TABLE techcare_product_component_price_techcare_product');
        $this->addSql('DROP TABLE techcare_product_component_price');
        $this->addSql('ALTER TABLE techcare_product ADD company_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_product DROP release_year');
        $this->addSql('COMMENT ON COLUMN techcare_product.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_product ADD CONSTRAINT FK_DAE7B095979B1AD6 FOREIGN KEY (company_id) REFERENCES techcare_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DAE7B095979B1AD6 ON techcare_product (company_id)');
        $this->addSql('ALTER TABLE techcare_quotation ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation DROP discount');
        $this->addSql('ALTER TABLE techcare_quotation DROP final_amount');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD service_id UUID NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP created_at');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP created_by');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP updated_at');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP updated_by');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP discount');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP final_amount');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP description');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP services');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.service_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEAED5CA9E6 FOREIGN KEY (service_id) REFERENCES techcare_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2499DEEAED5CA9E6 ON techcare_quotation_content (service_id)');
        $this->addSql('ALTER TABLE techcare_service DROP price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE techcare_product_component_price_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE techcare_product_component_price_techcare_component (techcare_product_component_price_id INT NOT NULL, techcare_component_id UUID NOT NULL, PRIMARY KEY(techcare_product_component_price_id, techcare_component_id))');
        $this->addSql('CREATE INDEX idx_9767e8b2e188f00f ON techcare_product_component_price_techcare_component (techcare_component_id)');
        $this->addSql('CREATE INDEX idx_9767e8b2d76b079c ON techcare_product_component_price_techcare_component (techcare_product_component_price_id)');
        $this->addSql('COMMENT ON COLUMN techcare_product_component_price_techcare_component.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_product_component_price_techcare_product (techcare_product_component_price_id INT NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_product_component_price_id, techcare_product_id))');
        $this->addSql('CREATE INDEX idx_67c501b47326692 ON techcare_product_component_price_techcare_product (techcare_product_id)');
        $this->addSql('CREATE INDEX idx_67c501bd76b079c ON techcare_product_component_price_techcare_product (techcare_product_component_price_id)');
        $this->addSql('COMMENT ON COLUMN techcare_product_component_price_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_product_component_price (id INT NOT NULL, price NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component ADD CONSTRAINT fk_9767e8b2d76b079c FOREIGN KEY (techcare_product_component_price_id) REFERENCES techcare_product_component_price (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component ADD CONSTRAINT fk_9767e8b2e188f00f FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product ADD CONSTRAINT fk_67c501bd76b079c FOREIGN KEY (techcare_product_component_price_id) REFERENCES techcare_product_component_price (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product ADD CONSTRAINT fk_67c501b47326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C2E188F00F');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT FK_7E5A9C247326692');
        $this->addSql('DROP TABLE techcare_component_techcare_product');
        $this->addSql('ALTER TABLE techcare_service ADD price NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEAED5CA9E6');
        $this->addSql('DROP INDEX IDX_2499DEEAED5CA9E6');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD created_by VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD updated_by VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD discount NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD final_amount NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD services JSON NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP service_id');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE techcare_product DROP CONSTRAINT FK_DAE7B095979B1AD6');
        $this->addSql('DROP INDEX IDX_DAE7B095979B1AD6');
        $this->addSql('ALTER TABLE techcare_product ADD release_year VARCHAR(4) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_product DROP company_id');
        $this->addSql('ALTER TABLE techcare_quotation ADD discount NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE techcare_quotation ADD final_amount NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE techcare_quotation DROP description');
    }
}
