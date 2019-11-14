<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113210022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE monitoring_result (id INT AUTO_INCREMENT NOT NULL, monitored_endpoint_id INT NOT NULL, check_date DATE NOT NULL, return_http_status_code INT NOT NULL, returned_payload VARCHAR(255) NOT NULL, INDEX IDX_54E97AF560CCCD (monitored_endpoint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE monitoring_result ADD CONSTRAINT FK_54E97AF560CCCD FOREIGN KEY (monitored_endpoint_id) REFERENCES monitored_endpoint (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monitoring_result DROP FOREIGN KEY FK_54E97AF560CCCD');
        $this->addSql('DROP TABLE monitoring_result');
        $this->addSql('DROP TABLE user');
    }
}
