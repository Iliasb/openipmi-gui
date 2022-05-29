<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528110158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, brand VARCHAR(100) DEFAULT NULL, model VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device ADD device_group_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E70608067 FOREIGN KEY (device_group_id) REFERENCES device_group (id)');
        $this->addSql('CREATE INDEX IDX_92FB68E70608067 ON device (device_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68E70608067');
        $this->addSql('DROP TABLE device_group');
        $this->addSql('DROP INDEX IDX_92FB68E70608067 ON device');
        $this->addSql('ALTER TABLE device ADD type VARCHAR(255) NOT NULL, DROP device_group_id');
    }
}
