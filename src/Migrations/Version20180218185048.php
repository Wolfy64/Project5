<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218185048 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation ADD aves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nao_observation ADD CONSTRAINT FK_A0D19034DC8E9D9E FOREIGN KEY (aves_id) REFERENCES nao_aves (id)');
        $this->addSql('CREATE INDEX IDX_A0D19034DC8E9D9E ON nao_observation (aves_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation DROP FOREIGN KEY FK_A0D19034DC8E9D9E');
        $this->addSql('DROP INDEX IDX_A0D19034DC8E9D9E ON nao_observation');
        $this->addSql('ALTER TABLE nao_observation DROP aves_id');
    }
}
