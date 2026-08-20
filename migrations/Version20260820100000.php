<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Renomme la table video en videos, ajoute premium_video (videos),
 * is_verified et image_name (users).
 */
final class Version20260820100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename video to videos, add premium_video, is_verified, image_name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('RENAME TABLE video TO videos');
        $this->addSql('ALTER TABLE videos ADD premium_video TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE users ADD is_verified TINYINT(1) DEFAULT 0 NOT NULL, ADD image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP is_verified, DROP image_name');
        $this->addSql('ALTER TABLE videos DROP premium_video');
        $this->addSql('RENAME TABLE videos TO video');
    }
}
