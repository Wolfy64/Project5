<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218192621 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE observation_aves (observation_id INT NOT NULL, aves_id INT NOT NULL, INDEX IDX_41715A491409DD88 (observation_id), INDEX IDX_41715A49DC8E9D9E (aves_id), PRIMARY KEY(observation_id, aves_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE observation_aves ADD CONSTRAINT FK_41715A491409DD88 FOREIGN KEY (observation_id) REFERENCES nao_observation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE observation_aves ADD CONSTRAINT FK_41715A49DC8E9D9E FOREIGN KEY (aves_id) REFERENCES nao_aves (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nao_observation DROP FOREIGN KEY FK_A0D19034DC8E9D9E');
        $this->addSql('DROP INDEX IDX_A0D19034DC8E9D9E ON nao_observation');
        $this->addSql('ALTER TABLE nao_observation DROP aves_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE observation_aves');
        $this->addSql('ALTER TABLE nao_observation ADD aves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nao_observation ADD CONSTRAINT FK_A0D19034DC8E9D9E FOREIGN KEY (aves_id) REFERENCES nao_aves (id)');
        $this->addSql('CREATE INDEX IDX_A0D19034DC8E9D9E ON nao_observation (aves_id)');
    }
}
