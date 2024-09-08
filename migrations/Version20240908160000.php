<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at, updated_at, and deleted_at columns to the food table';
    }

    public function up(Schema $schema): void
    {
        // Alter the existing 'food' table to add timestamp columns
        $this->addSql('ALTER TABLE food 
            ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            ADD updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, 
            ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Reverse the changes by removing the columns
        $this->addSql('ALTER TABLE food 
            DROP created_at, 
            DROP updated_at, 
            DROP deleted_at');
    }
}
