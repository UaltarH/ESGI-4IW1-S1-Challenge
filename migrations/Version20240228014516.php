<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228014516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techcare_quotation_content ADD component_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN techcare_quotation_content.component_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_quotation_content ADD CONSTRAINT FK_2499DEEAE2ABAFFF FOREIGN KEY (component_id) REFERENCES techcare_component (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2499DEEAE2ABAFFF ON techcare_quotation_content (component_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP CONSTRAINT FK_2499DEEAE2ABAFFF');
        $this->addSql('DROP INDEX IDX_2499DEEAE2ABAFFF');
        $this->addSql('ALTER TABLE techcare_quotation_content DROP component_id');
    }
}
