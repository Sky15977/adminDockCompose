<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031093553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE container_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE organization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sensor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE container (id INT NOT NULL, group_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7A2EC1BFE54D947 ON container (group_id)');
        $this->addSql('CREATE TABLE contract (id INT NOT NULL, container_id INT NOT NULL, sensor_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E98F2859BC21F742 ON contract (container_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E98F2859A247991F ON contract (sensor_id)');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, organization_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DC044C532C8A3DE ON "group" (organization_id)');
        $this->addSql('CREATE TABLE organization (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sensor (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1BFE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859BC21F742 FOREIGN KEY (container_id) REFERENCES container (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859A247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT FK_6DC044C532C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE container_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contract_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE organization_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sensor_id_seq CASCADE');
        $this->addSql('ALTER TABLE container DROP CONSTRAINT FK_C7A2EC1BFE54D947');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859BC21F742');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F2859A247991F');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT FK_6DC044C532C8A3DE');
        $this->addSql('DROP TABLE container');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE sensor');
    }
}
