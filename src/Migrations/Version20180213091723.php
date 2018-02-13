<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180213091723 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation DROP image_name, DROP image_size, DROP updated_at, CHANGE latitude latitude VARCHAR(255) NOT NULL, CHANGE longitude longitude VARCHAR(255) NOT NULL, CHANGE place image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation ADD image_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD image_size INT NOT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL, CHANGE image place VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
