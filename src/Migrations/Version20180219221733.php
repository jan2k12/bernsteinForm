<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219221733 extends AbstractMigration
{
    public function up(Schema $schema)  :void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teilnehmer (id INT AUTO_INCREMENT NOT NULL, agegroupe_id INT NOT NULL, bowclass_id INT NOT NULL, turnier_id INT NOT NULL, name VARCHAR(255) NOT NULL, prename VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, plz VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(2) NOT NULL, email VARCHAR(255) NOT NULL, society VARCHAR(255) NOT NULL, INDEX IDX_F25E8A041A4F8BA5 (agegroupe_id), INDEX IDX_F25E8A045833BB8D (bowclass_id), INDEX IDX_F25E8A04B5FFB8C1 (turnier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bowclass (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agegroup (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teilnehmer ADD CONSTRAINT FK_F25E8A041A4F8BA5 FOREIGN KEY (agegroupe_id) REFERENCES agegroup (id)');
        $this->addSql('ALTER TABLE teilnehmer ADD CONSTRAINT FK_F25E8A045833BB8D FOREIGN KEY (bowclass_id) REFERENCES bowclass (id)');
        $this->addSql('ALTER TABLE teilnehmer ADD CONSTRAINT FK_F25E8A04B5FFB8C1 FOREIGN KEY (turnier_id) REFERENCES turnier_form (id)');
    }

    public function down(Schema $schema) :void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teilnehmer DROP FOREIGN KEY FK_F25E8A045833BB8D');
        $this->addSql('ALTER TABLE teilnehmer DROP FOREIGN KEY FK_F25E8A041A4F8BA5');
        $this->addSql('DROP TABLE teilnehmer');
        $this->addSql('DROP TABLE bowclass');
        $this->addSql('DROP TABLE agegroup');
    }
}
