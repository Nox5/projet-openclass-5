<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008091758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wish_list (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_5B8739BDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wish_list ADD CONSTRAINT FK_5B8739BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bande_dessinee ADD wish_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bande_dessinee ADD CONSTRAINT FK_4BF85642D69F3311 FOREIGN KEY (wish_list_id) REFERENCES wish_list (id)');
        $this->addSql('CREATE INDEX IDX_4BF85642D69F3311 ON bande_dessinee (wish_list_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bande_dessinee DROP FOREIGN KEY FK_4BF85642D69F3311');
        $this->addSql('DROP TABLE wish_list');
        $this->addSql('DROP INDEX IDX_4BF85642D69F3311 ON bande_dessinee');
        $this->addSql('ALTER TABLE bande_dessinee DROP wish_list_id');
    }
}
