<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523155126 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teilnehmer ADD birth_date DATE DEFAULT NULL AFTER prename');
        $this->addSql('ALTER TABLE agegroup ADD max_age INT NOT NULL');
        $this->addSql('ALTER TABLE turnier_form CHANGE pay_by_bank bank_payment TINYINT(1) DEFAULT \'1\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agegroup DROP max_age');
        $this->addSql('ALTER TABLE teilnehmer DROP birth_date');
        $this->addSql('ALTER TABLE turnier_form CHANGE bank_payment pay_by_bank TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
