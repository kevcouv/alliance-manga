<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511095712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manga (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, manga_id INT NOT NULL, title VARCHAR(255) NOT NULL, small_description LONGTEXT NOT NULL, full_description LONGTEXT NOT NULL, name_character VARCHAR(255) NOT NULL, price VARCHAR(120) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, is_published TINYINT(1) NOT NULL, material VARCHAR(120) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D34A04AD7B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7B6461');
        $this->addSql('DROP TABLE manga');
        $this->addSql('DROP TABLE product');
    }
}