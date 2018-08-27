<?php declare(strict_types=1);

namespace Pondo\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180522163158 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_url (url_id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, size_xs VARCHAR(255) NOT NULL, size_s VARCHAR(255) NOT NULL, size_m VARCHAR(255) NOT NULL, size_l VARCHAR(255) NOT NULL, size_xl VARCHAR(255) NOT NULL, size_xxl VARCHAR(255) NOT NULL, price NUMERIC(13, 4) NOT NULL, PRIMARY KEY(url_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_url');
    }
}
