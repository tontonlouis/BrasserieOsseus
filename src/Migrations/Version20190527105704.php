<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190527105704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_product ADD orders_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE6CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_2530ADE6CFFE9AD6 ON order_product (orders_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6CFFE9AD6');
        $this->addSql('DROP INDEX IDX_2530ADE6CFFE9AD6 ON order_product');
        $this->addSql('ALTER TABLE order_product DROP orders_id');
    }
}
