<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110083343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_book_read (user_id INT NOT NULL, book_read_id INT NOT NULL, INDEX IDX_812A878BA76ED395 (user_id), INDEX IDX_812A878BA4948A88 (book_read_id), PRIMARY KEY(user_id, book_read_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_book_read ADD CONSTRAINT FK_812A878BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_book_read ADD CONSTRAINT FK_812A878BA4948A88 FOREIGN KEY (book_read_id) REFERENCES book_read (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_read ADD is_finished TINYINT(1) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_book_read DROP FOREIGN KEY FK_812A878BA76ED395');
        $this->addSql('ALTER TABLE user_book_read DROP FOREIGN KEY FK_812A878BA4948A88');
        $this->addSql('DROP TABLE user_book_read');
        $this->addSql('ALTER TABLE book_read DROP is_finished, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
