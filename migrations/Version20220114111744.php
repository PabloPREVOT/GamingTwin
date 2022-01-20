<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114111744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(50) NOT NULL, discord_id VARCHAR(30) DEFAULT NULL, steam_id VARCHAR(50) DEFAULT NULL, tryhard_meter INT NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FD71A9C586CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur_categorie (joueur_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_B7234C6CA9E2D76C (joueur_id), INDEX IDX_B7234C6CBCF5E72D (categorie_id), PRIMARY KEY(joueur_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur_jeu (joueur_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_AD9D2A82A9E2D76C (joueur_id), INDEX IDX_AD9D2A828C9E392E (jeu_id), PRIMARY KEY(joueur_id, jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueur_categorie ADD CONSTRAINT FK_B7234C6CA9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur_categorie ADD CONSTRAINT FK_B7234C6CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur_jeu ADD CONSTRAINT FK_AD9D2A82A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur_jeu ADD CONSTRAINT FK_AD9D2A828C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur_categorie DROP FOREIGN KEY FK_B7234C6CBCF5E72D');
        $this->addSql('ALTER TABLE joueur_jeu DROP FOREIGN KEY FK_AD9D2A828C9E392E');
        $this->addSql('ALTER TABLE joueur_categorie DROP FOREIGN KEY FK_B7234C6CA9E2D76C');
        $this->addSql('ALTER TABLE joueur_jeu DROP FOREIGN KEY FK_AD9D2A82A9E2D76C');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE joueur_categorie');
        $this->addSql('DROP TABLE joueur_jeu');
    }
}
