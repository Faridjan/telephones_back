<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306091707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content (id UUID NOT NULL, content_json VARCHAR(255) DEFAULT NULL, content_html VARCHAR(255) DEFAULT NULL, content_img VARCHAR(255) DEFAULT NULL, content_file VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN content.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN content.content_html IS \'(DC2Type:content_html_type)\'');
        $this->addSql('COMMENT ON COLUMN content.content_img IS \'(DC2Type:content_img_type)\'');
        $this->addSql('COMMENT ON COLUMN content.content_file IS \'(DC2Type:content_file_type)\'');
        $this->addSql('COMMENT ON COLUMN content.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN content.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mark (id UUID NOT NULL, content_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, coordinates VARCHAR(255) NOT NULL, options VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6674F2715E237E06 ON mark (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6674F27184A0A3ED ON mark (content_id)');
        $this->addSql('COMMENT ON COLUMN mark.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN mark.content_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN mark.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN mark.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F27184A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT FK_6674F27184A0A3ED');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE mark');
    }
}
