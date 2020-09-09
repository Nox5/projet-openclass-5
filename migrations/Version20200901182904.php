<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901182904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur_bande_dessinee (auteur_id INT NOT NULL, bande_dessinee_id INT NOT NULL, INDEX IDX_43A61CD760BB6FE6 (auteur_id), INDEX IDX_43A61CD74AD81C29 (bande_dessinee_id), PRIMARY KEY(auteur_id, bande_dessinee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auteur_bande_dessinee ADD CONSTRAINT FK_43A61CD760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auteur_bande_dessinee ADD CONSTRAINT FK_43A61CD74AD81C29 FOREIGN KEY (bande_dessinee_id) REFERENCES bande_dessinee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE auteur_bande_dessinee');
    }
}
