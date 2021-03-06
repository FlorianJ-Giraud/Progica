<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616223739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement CHANGE name name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE gite ADD proprietaire_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE description description TINYTEXT NOT NULL');
        $this->addSql('ALTER TABLE gite ADD CONSTRAINT FK_B638C92C76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B638C92C76C50E4A ON gite (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE gite DROP FOREIGN KEY FK_B638C92C76C50E4A');
        $this->addSql('DROP INDEX IDX_B638C92C76C50E4A ON gite');
        $this->addSql('ALTER TABLE gite DROP proprietaire_id, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL');
    }
}
