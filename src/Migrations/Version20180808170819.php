<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180808170819 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_of_event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE dictonary');
        $this->addSql('DROP TABLE doctrine');
        $this->addSql('ALTER TABLE tournament ADD type_of_event_id INT DEFAULT NULL, DROP dictonary_id_id');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D98675C9F1 FOREIGN KEY (type_of_event_id) REFERENCES type_of_event (id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D98675C9F1 ON tournament (type_of_event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D98675C9F1');
        $this->addSql('CREATE TABLE dictonary (id INT AUTO_INCREMENT NOT NULL, type_tournament VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE type_of_event');
        $this->addSql('DROP INDEX IDX_BD5FB8D98675C9F1 ON tournament');
        $this->addSql('ALTER TABLE tournament ADD dictonary_id_id INT NOT NULL, DROP type_of_event_id');
    }
}
