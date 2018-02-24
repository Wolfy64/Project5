<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224042615 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_aves DROP FOREIGN KEY FK_CC03F4C41409DD88');
        $this->addSql('DROP INDEX IDX_CC03F4C41409DD88 ON nao_aves');
        $this->addSql('ALTER TABLE nao_aves DROP observation_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nao_aves ADD observation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nao_aves ADD CONSTRAINT FK_CC03F4C41409DD88 FOREIGN KEY (observation_id) REFERENCES nao_observation (id)');
        $this->addSql('CREATE INDEX IDX_CC03F4C41409DD88 ON nao_aves (observation_id)');
    }
}
