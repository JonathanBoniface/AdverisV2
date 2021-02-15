<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214105332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, companies_id INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, price_sold DOUBLE PRECISION NOT NULL, estimated_time INT NOT NULL, spent_time INT NOT NULL, technology VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_5C93B3A46AE4741E (companies_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_workers (projects_id INT NOT NULL, workers_id INT NOT NULL, INDEX IDX_95EE66D11EDE0F55 (projects_id), INDEX IDX_95EE66D128A00806 (workers_id), PRIMARY KEY(projects_id, workers_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A46AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE projects_workers ADD CONSTRAINT FK_95EE66D11EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_workers ADD CONSTRAINT FK_95EE66D128A00806 FOREIGN KEY (workers_id) REFERENCES workers (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A46AE4741E');
        $this->addSql('ALTER TABLE projects_workers DROP FOREIGN KEY FK_95EE66D11EDE0F55');
        $this->addSql('ALTER TABLE projects_workers DROP FOREIGN KEY FK_95EE66D128A00806');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_workers');
        $this->addSql('DROP TABLE workers');
    }
}
