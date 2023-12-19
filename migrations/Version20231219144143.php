<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219144143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE techcare_user_techcarerole (techcare_user_id UUID NOT NULL, techcarerole_id UUID NOT NULL, PRIMARY KEY(techcare_user_id, techcarerole_id))');
        $this->addSql('CREATE INDEX IDX_F871A308AEC367AD ON techcare_user_techcarerole (techcare_user_id)');
        $this->addSql('CREATE INDEX IDX_F871A30834C8D623 ON techcare_user_techcarerole (techcarerole_id)');
        $this->addSql('COMMENT ON COLUMN techcare_user_techcarerole.techcare_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN techcare_user_techcarerole.techcarerole_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE techcare_user_techcarerole ADD CONSTRAINT FK_F871A308AEC367AD FOREIGN KEY (techcare_user_id) REFERENCES techcare_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE techcare_user_techcarerole ADD CONSTRAINT FK_F871A30834C8D623 FOREIGN KEY (techcarerole_id) REFERENCES techcare_role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE techcare_user_techcarerole DROP CONSTRAINT FK_F871A308AEC367AD');
        $this->addSql('ALTER TABLE techcare_user_techcarerole DROP CONSTRAINT FK_F871A30834C8D623');
        $this->addSql('DROP TABLE techcare_user_techcarerole');
    }
}
