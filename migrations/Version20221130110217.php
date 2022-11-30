<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130110217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add report entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, category_id INT NOT NULL, email VARCHAR(180) NOT NULL, content LONGTEXT NOT NULL, is_close TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_C42F77847294869C (article_id), INDEX IDX_C42F778412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77847294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F778412469DE2 FOREIGN KEY (category_id) REFERENCES report_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77847294869C');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F778412469DE2');
        $this->addSql('DROP TABLE report');
    }
}
