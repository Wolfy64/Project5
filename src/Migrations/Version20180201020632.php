<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180201020632 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE observation (id INT AUTO_INCREMENT NOT NULL, species VARCHAR(255) NOT NULL, date DATE NOT NULL, town VARCHAR(255) NOT NULL, gps VARCHAR(255) NOT NULL, numbers INT NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aves CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE post CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE app_users CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824F85E0677 ON app_users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824E7927C74 ON app_users (email)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE observation');
        $this->addSql('ALTER TABLE app_users MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C2502824F85E0677 ON app_users');
        $this->addSql('DROP INDEX UNIQ_C2502824E7927C74 ON app_users');
        $this->addSql('ALTER TABLE app_users DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE app_users CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE aves MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE aves DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE aves CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE post MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE post DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE post CHANGE id id INT NOT NULL');
    }
}
