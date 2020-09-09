<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901182601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_dessinee DROP FOREIGN KEY FK_4BF85642E9F581D3');
        $this->addSql('DROP INDEX IDX_4BF85642E9F581D3 ON bande_dessinee');
        $this->addSql('ALTER TABLE bande_dessinee DROP auteurbd_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_dessinee ADD auteurbd_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bande_dessinee ADD CONSTRAINT FK_4BF85642E9F581D3 FOREIGN KEY (auteurbd_id) REFERENCES auteur (id)');
        $this->addSql('CREATE INDEX IDX_4BF85642E9F581D3 ON bande_dessinee (auteurbd_id)');
    }
}
