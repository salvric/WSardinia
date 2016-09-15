<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160909141257 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784181E5FEC79');
        $this->addSql('DROP INDEX IDX_14B784181E5FEC79 ON photo');
        $this->addSql('ALTER TABLE photo ADD location_id INT NOT NULL, DROP id_location_id');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841864D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_14B7841864D218E ON photo (location_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841864D218E');
        $this->addSql('DROP INDEX IDX_14B7841864D218E ON photo');
        $this->addSql('ALTER TABLE photo ADD id_location_id INT DEFAULT NULL, DROP location_id');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784181E5FEC79 FOREIGN KEY (id_location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_14B784181E5FEC79 ON photo (id_location_id)');
    }
}
