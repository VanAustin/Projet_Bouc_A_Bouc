<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171004093655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE valid valid TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE friend CHANGE accepted accepted TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE description description LONGTEXT DEFAULT NULL, CHANGE page_count page_count BIGINT DEFAULT NULL, CHANGE published_at published_at DATE DEFAULT NULL, CHANGE editor editor VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collection CHANGE loanable loanable TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE borrowed borrowed TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE borrow_ask borrow_ask TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE borrower borrower VARCHAR(255) DEFAULT NULL, CHANGE borrow_date borrow_date DATE DEFAULT NULL, CHANGE borrow_comment borrow_comment LONGTEXT DEFAULT NULL, CHANGE private private TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book CHANGE description description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE page_count page_count BIGINT NOT NULL, CHANGE published_at published_at DATE NOT NULL, CHANGE editor editor VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE picture picture VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE collection CHANGE loanable loanable TINYINT(1) NOT NULL, CHANGE borrowed borrowed TINYINT(1) NOT NULL, CHANGE borrow_ask borrow_ask TINYINT(1) NOT NULL, CHANGE borrower borrower VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE borrow_date borrow_date DATE NOT NULL, CHANGE borrow_comment borrow_comment LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE private private TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE valid valid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE friend CHANGE accepted accepted TINYINT(1) NOT NULL');
    }
}
