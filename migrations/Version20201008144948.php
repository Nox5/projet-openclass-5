<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008144948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wish_list_wish_list (wish_list_source INT NOT NULL, wish_list_target INT NOT NULL, INDEX IDX_97ADDF2EDBA404D4 (wish_list_source), INDEX IDX_97ADDF2EC241545B (wish_list_target), PRIMARY KEY(wish_list_source, wish_list_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wish_list_wish_list ADD CONSTRAINT FK_97ADDF2EDBA404D4 FOREIGN KEY (wish_list_source) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_list_wish_list ADD CONSTRAINT FK_97ADDF2EC241545B FOREIGN KEY (wish_list_target) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bande_dessinee DROP FOREIGN KEY FK_4BF85642D69F3311');
        $this->addSql('DROP INDEX IDX_4BF85642D69F3311 ON bande_dessinee');
        $this->addSql('ALTER TABLE bande_dessinee DROP wish_list_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE wish_list_wish_list');
        $this->addSql('ALTER TABLE bande_dessinee ADD wish_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bande_dessinee ADD CONSTRAINT FK_4BF85642D69F3311 FOREIGN KEY (wish_list_id) REFERENCES wish_list (id)');
        $this->addSql('CREATE INDEX IDX_4BF85642D69F3311 ON bande_dessinee (wish_list_id)');
    }
}
