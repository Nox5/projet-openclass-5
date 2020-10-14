<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008151653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wish_list_bande_dessinee (wish_list_id INT NOT NULL, bande_dessinee_id INT NOT NULL, INDEX IDX_7CDF4E12D69F3311 (wish_list_id), INDEX IDX_7CDF4E124AD81C29 (bande_dessinee_id), PRIMARY KEY(wish_list_id, bande_dessinee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wish_list_bande_dessinee ADD CONSTRAINT FK_7CDF4E12D69F3311 FOREIGN KEY (wish_list_id) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_list_bande_dessinee ADD CONSTRAINT FK_7CDF4E124AD81C29 FOREIGN KEY (bande_dessinee_id) REFERENCES bande_dessinee (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE wish_list_wish_list');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wish_list_wish_list (wish_list_source INT NOT NULL, wish_list_target INT NOT NULL, INDEX IDX_97ADDF2EDBA404D4 (wish_list_source), INDEX IDX_97ADDF2EC241545B (wish_list_target), PRIMARY KEY(wish_list_source, wish_list_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE wish_list_wish_list ADD CONSTRAINT FK_97ADDF2EC241545B FOREIGN KEY (wish_list_target) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_list_wish_list ADD CONSTRAINT FK_97ADDF2EDBA404D4 FOREIGN KEY (wish_list_source) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE wish_list_bande_dessinee');
    }
}
