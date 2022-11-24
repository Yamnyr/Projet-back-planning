<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124105051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_groupe (evenement_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_B74C5CA3FD02F13 (evenement_id), INDEX IDX_B74C5CA37A45358C (groupe_id), PRIMARY KEY(evenement_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement_groupe ADD CONSTRAINT FK_B74C5CA3FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_groupe ADD CONSTRAINT FK_B74C5CA37A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement_groupe DROP FOREIGN KEY FK_B74C5CA3FD02F13');
        $this->addSql('ALTER TABLE evenement_groupe DROP FOREIGN KEY FK_B74C5CA37A45358C');
        $this->addSql('DROP TABLE evenement_groupe');
    }
}
