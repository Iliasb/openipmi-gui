<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604093947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE device_group ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE network ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE rack ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device DROP description');
        $this->addSql('ALTER TABLE device_group DROP description');
        $this->addSql('ALTER TABLE location DROP description');
        $this->addSql('ALTER TABLE network DROP description');
        $this->addSql('ALTER TABLE rack DROP description');
    }
}
