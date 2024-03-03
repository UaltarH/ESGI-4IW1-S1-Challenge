<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224011459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE techcare_product_component_price_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE techcare_product_component_price (id INT NOT NULL, price NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE techcare_product_component_price_techcare_product (techcare_product_component_price_id INT NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_product_component_price_id, techcare_product_id))');
        $this->addSql('CREATE INDEX IDX_67C501BD76B079C ON techcare_product_component_price_techcare_product (techcare_product_component_price_id)');
        $this->addSql('CREATE INDEX IDX_67C501B47326692 ON techcare_product_component_price_techcare_product (techcare_product_id)');
        $this->addSql('COMMENT ON COLUMN techcare_product_component_price_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE techcare_product_component_price_techcare_component (techcare_product_component_price_id INT NOT NULL, techcare_component_id UUID NOT NULL, PRIMARY KEY(techcare_product_component_price_id, techcare_component_id))');
        $this->addSql('CREATE INDEX IDX_9767E8B2D76B079C ON techcare_product_component_price_techcare_component (techcare_product_component_price_id)');
        $this->addSql('CREATE INDEX IDX_9767E8B2E188F00F ON techcare_product_component_price_techcare_component (techcare_component_id)');
        $this->addSql('COMMENT ON COLUMN techcare_product_component_price_techcare_component.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product ADD CONSTRAINT FK_67C501BD76B079C FOREIGN KEY (techcare_product_component_price_id) REFERENCES techcare_product_component_price (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product ADD CONSTRAINT FK_67C501B47326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component ADD CONSTRAINT FK_9767E8B2D76B079C FOREIGN KEY (techcare_product_component_price_id) REFERENCES techcare_product_component_price (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component ADD CONSTRAINT FK_9767E8B2E188F00F FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE techcare_product_component_price_id_seq CASCADE');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product DROP CONSTRAINT FK_67C501BD76B079C');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_product DROP CONSTRAINT FK_67C501B47326692');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component DROP CONSTRAINT FK_9767E8B2D76B079C');
        $this->addSql('ALTER TABLE techcare_product_component_price_techcare_component DROP CONSTRAINT FK_9767E8B2E188F00F');
        $this->addSql('DROP TABLE techcare_product_component_price');
        $this->addSql('DROP TABLE techcare_product_component_price_techcare_product');
        $this->addSql('DROP TABLE techcare_product_component_price_techcare_component');
    }
}
