<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180225201813 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE nao_observation ADD CONSTRAINT FK_A0D19034A76ED395 FOREIGN KEY (user_id) REFERENCES nao_user (id)');
        $this->addSql('CREATE INDEX IDX_A0D19034A76ED395 ON nao_observation (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_observation DROP FOREIGN KEY FK_A0D19034A76ED395');
        $this->addSql('DROP INDEX IDX_A0D19034A76ED395 ON nao_observation');
        $this->addSql('ALTER TABLE nao_observation DROP user_id');
    }
}
