<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327144947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, date_creation DATETIME NOT NULL, code_postal VARCHAR(25) NOT NULL, ville VARCHAR(100) NOT NULL, nom_proprietaire VARCHAR(255) NOT NULL, prenom_proprietaire VARCHAR(200) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, nom_animal VARCHAR(200) NOT NULL, description LONGTEXT DEFAULT NULL, adresse_mail VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, category VARCHAR(100) NOT NULL, espece VARCHAR(50) NOT NULL, age_animal INT NOT NULL, sexe_animal VARCHAR(150) NOT NULL, puce VARCHAR(100) NOT NULL, tatoue VARCHAR(100) NOT NULL, taille_poil VARCHAR(100) NOT NULL, dessin_poil VARCHAR(100) NOT NULL, couleur_poil LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_F65593E56A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F6B4FB29E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, annonce_id INT NOT NULL, message LONGTEXT NOT NULL, date_message DATETIME NOT NULL, INDEX IDX_B6BD307F6A99F74A (membre_id), INDEX IDX_B6BD307F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56A99F74A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8805AB2F');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F6A99F74A');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8805AB2F');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
