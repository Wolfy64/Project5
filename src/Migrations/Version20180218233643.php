<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218233643 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_aves ADD `order` VARCHAR(25) NOT NULL, ADD family VARCHAR(25) NOT NULL, ADD scientific_name VARCHAR(60) NOT NULL, ADD author VARCHAR(60) NOT NULL, DROP ordre, DROP famille, DROP lb_name, DROP lb_auteur, CHANGE nom_vern common_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE nao_observation CHANGE species common_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_aves ADD ordre VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, ADD famille VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, ADD lb_name VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, ADD lb_auteur VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, DROP `order`, DROP family, DROP scientific_name, DROP author, CHANGE common_name nom_vern VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE nao_observation CHANGE common_name species VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
