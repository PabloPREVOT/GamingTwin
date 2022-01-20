<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220118145129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE synchro (id INT AUTO_INCREMENT NOT NULL, joueur1_id INT NOT NULL, joueur2_id INT NOT NULL, INDEX IDX_E590252592C1E237 (joueur1_id), INDEX IDX_E590252580744DD9 (joueur2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synchro ADD CONSTRAINT FK_E590252592C1E237 FOREIGN KEY (joueur1_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE synchro ADD CONSTRAINT FK_E590252580744DD9 FOREIGN KEY (joueur2_id) REFERENCES joueur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE synchro');
    }
}
