<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215133045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP CONSTRAINT fk_cbe5a331f675f31b');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT fk_cbe5a3316995ac4c');
        $this->addSql('DROP INDEX idx_cbe5a331f675f31b');
        $this->addSql('DROP INDEX idx_cbe5a3316995ac4c');
        $this->addSql('ALTER TABLE book ADD author VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD editor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE book DROP author_id');
        $this->addSql('ALTER TABLE book DROP editor_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD editor_id INT NOT NULL');
        $this->addSql('ALTER TABLE book DROP author');
        $this->addSql('ALTER TABLE book DROP editor');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_cbe5a331f675f31b FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_cbe5a3316995ac4c FOREIGN KEY (editor_id) REFERENCES editor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_cbe5a331f675f31b ON book (author_id)');
        $this->addSql('CREATE INDEX idx_cbe5a3316995ac4c ON book (editor_id)');
    }
}
