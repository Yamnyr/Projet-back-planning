<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124111319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_6514B6AAFB88E14F (utilisateur_id), INDEX IDX_6514B6AA7A45358C (groupe_id), PRIMARY KEY(utilisateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_matiere (utilisateur_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_EA1FA0D8FB88E14F (utilisateur_id), INDEX IDX_EA1FA0D8F46CD258 (matiere_id), PRIMARY KEY(utilisateur_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_matiere ADD CONSTRAINT FK_EA1FA0D8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_matiere ADD CONSTRAINT FK_EA1FA0D8F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AAFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C');
        $this->addSql('ALTER TABLE utilisateur_matiere DROP FOREIGN KEY FK_EA1FA0D8FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_matiere DROP FOREIGN KEY FK_EA1FA0D8F46CD258');
        $this->addSql('DROP TABLE utilisateur_groupe');
        $this->addSql('DROP TABLE utilisateur_matiere');
    }
}
