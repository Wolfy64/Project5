<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224044804 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nao_observation_aves (observation_id INT NOT NULL, aves_id INT NOT NULL, INDEX IDX_B5AC88EB1409DD88 (observation_id), INDEX IDX_B5AC88EBDC8E9D9E (aves_id), PRIMARY KEY(observation_id, aves_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nao_observation_aves ADD CONSTRAINT FK_B5AC88EB1409DD88 FOREIGN KEY (observation_id) REFERENCES nao_observation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nao_observation_aves ADD CONSTRAINT FK_B5AC88EBDC8E9D9E FOREIGN KEY (aves_id) REFERENCES nao_aves (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE nao_observation_aves');
    }
}
