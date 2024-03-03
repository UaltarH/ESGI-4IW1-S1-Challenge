<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224021852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEA4584665A');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEA4584665A FOREIGN KEY (product_id) REFERENCES techcare_product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT fk_2499deea4584665a');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT fk_2499deea4584665a FOREIGN KEY (product_id) REFERENCES techcare_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
