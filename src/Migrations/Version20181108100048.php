<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181108100048 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, barcode VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cost NUMERIC(10, 2) NOT NULL, vatclass INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, discount INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE register (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, receipt_id INT NOT NULL, count INT NOT NULL, INDEX IDX_5FF940144584665A (product_id), INDEX IDX_5FF940142B5CA896 (receipt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE register ADD CONSTRAINT FK_5FF940144584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE register ADD CONSTRAINT FK_5FF940142B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE register DROP FOREIGN KEY FK_5FF940144584665A');
        $this->addSql('ALTER TABLE register DROP FOREIGN KEY FK_5FF940142B5CA896');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE register');
    }
}
