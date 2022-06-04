<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604103244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE device_group ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE location ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE network ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE project ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE rack ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
        $this->addSql('ALTER TABLE user ADD created DATE NOT NULL, ADD updated DATE NOT NULL, ADD content_changed DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE device_group DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE location DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE network DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE project DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE rack DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE reservation DROP created, DROP updated, DROP content_changed');
        $this->addSql('ALTER TABLE user DROP created, DROP updated, DROP content_changed');
    }
}
