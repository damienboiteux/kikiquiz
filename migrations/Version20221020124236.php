<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020124236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1F7AE0F1A');
        $this->addSql('DROP INDEX IDX_383B09B1F7AE0F1A ON eleves');
        $this->addSql('ALTER TABLE eleves DROP examens_id');
        $this->addSql('ALTER TABLE examens ADD eleves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE examens ADD CONSTRAINT FK_B2E32DD7C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id)');
        $this->addSql('CREATE INDEX IDX_B2E32DD7C2140342 ON examens (eleves_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examens DROP FOREIGN KEY FK_B2E32DD7C2140342');
        $this->addSql('DROP INDEX IDX_B2E32DD7C2140342 ON examens');
        $this->addSql('ALTER TABLE examens DROP eleves_id');
        $this->addSql('ALTER TABLE eleves ADD examens_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1F7AE0F1A FOREIGN KEY (examens_id) REFERENCES examens (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_383B09B1F7AE0F1A ON eleves (examens_id)');
    }
}
