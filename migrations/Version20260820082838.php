<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260820082838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users CHANGE is_verified is_verified TINYINT NOT NULL');
        $this->addSql('ALTER TABLE videos CHANGE premium_video premium_video TINYINT NOT NULL');
        $this->addSql('ALTER TABLE videos RENAME INDEX idx_7cc7da2ca76ed395 TO IDX_29AA6432A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE users CHANGE is_verified is_verified TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE videos CHANGE premium_video premium_video TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE videos RENAME INDEX idx_29aa6432a76ed395 TO IDX_7CC7DA2CA76ED395');
    }
}
