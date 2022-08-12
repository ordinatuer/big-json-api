<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220810164513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Таблица с ценами по регионам';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price (product_id INT NOT NULL, region_id INT NOT NULL, price_purchase DOUBLE PRECISION NOT NULL, price_selling DOUBLE PRECISION NOT NULL, price_discount DOUBLE PRECISION NOT NULL, PRIMARY KEY(product_id, region_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE price');
    }
}
