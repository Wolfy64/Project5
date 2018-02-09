<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180209191033 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nao_aves (id INT AUTO_INCREMENT NOT NULL, ordre VARCHAR(25) NOT NULL, famille VARCHAR(25) NOT NULL, lb_name VARCHAR(60) NOT NULL, lb_auteur VARCHAR(60) NOT NULL, nom_vern VARCHAR(255) NOT NULL, habitat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nao_post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, article LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nao_observation (id INT AUTO_INCREMENT NOT NULL, species VARCHAR(255) NOT NULL, date DATE NOT NULL, place VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, numbers INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT NOT NULL, updated_at DATETIME DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE aves');
        $this->addSql('DROP TABLE observation');
        $this->addSql('DROP TABLE post');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:simple_array)\', first_name VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, last_name VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aves (id INT AUTO_INCREMENT NOT NULL, ordre VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, famille VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, lb_name VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, lb_auteur VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, nom_vern VARCHAR(120) NOT NULL COLLATE utf8_unicode_ci, habitat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE observation (id INT AUTO_INCREMENT NOT NULL, species VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, date DATE NOT NULL, latitude DOUBLE PRECISION NOT NULL, numbers INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, content VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, article LONGTEXT NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE nao_aves');
        $this->addSql('DROP TABLE nao_post');
        $this->addSql('DROP TABLE nao_observation');
    }
}
