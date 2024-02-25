<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224144255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT fk_7e5a9c2e188f00f');
        $this->addSql('ALTER TABLE techcare_component_techcare_product DROP CONSTRAINT fk_7e5a9c247326692');
        $this->addSql('DROP TABLE techcare_component_techcare_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE techcare_component_techcare_product (techcare_component_id UUID NOT NULL, techcare_product_id UUID NOT NULL, PRIMARY KEY(techcare_component_id, techcare_product_id))');
        $this->addSql('CREATE INDEX idx_7e5a9c247326692 ON techcare_component_techcare_product (techcare_product_id)');
        $this->addSql('CREATE INDEX idx_7e5a9c2e188f00f ON techcare_component_techcare_product (techcare_component_id)');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_component_techcare_product.techcare_product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT fk_7e5a9c2e188f00f FOREIGN KEY (techcare_component_id) REFERENCES techcare_component (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_component_techcare_product ADD CONSTRAINT fk_7e5a9c247326692 FOREIGN KEY (techcare_product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
