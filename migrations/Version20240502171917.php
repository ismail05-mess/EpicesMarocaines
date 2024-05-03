<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502171917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_produit (recette_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_EDDD365D89312FE9 (recette_id), INDEX IDX_EDDD365DF347EFB (produit_id), PRIMARY KEY(recette_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_produit ADD CONSTRAINT FK_EDDD365D89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_produit ADD CONSTRAINT FK_EDDD365DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_produit DROP FOREIGN KEY FK_EDDD365D89312FE9');
        $this->addSql('ALTER TABLE recette_produit DROP FOREIGN KEY FK_EDDD365DF347EFB');
        $this->addSql('DROP TABLE recette_produit');
    }
}
