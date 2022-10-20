<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012171135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleves (id INT AUTO_INCREMENT NOT NULL, examens_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_383B09B1F7AE0F1A (examens_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleves_classes (eleves_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_68D087BC2140342 (eleves_id), INDEX IDX_68D087B9E225B24 (classes_id), PRIMARY KEY(eleves_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examens (id INT AUTO_INCREMENT NOT NULL, questionnaires_id INT DEFAULT NULL, INDEX IDX_B2E32DD7CABD5540 (questionnaires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, consigne LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires_questions (questionnaires_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_BC372841CABD5540 (questionnaires_id), INDEX IDX_BC372841BCB134CE (questions_id), PRIMARY KEY(questionnaires_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires_classes (questionnaires_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_8C5BE782CABD5540 (questionnaires_id), INDEX IDX_8C5BE7829E225B24 (classes_id), PRIMARY KEY(questionnaires_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(16) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, questions_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, success TINYINT(1) NOT NULL, INDEX IDX_1E512EC6BCB134CE (questions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses_eleves (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1F7AE0F1A FOREIGN KEY (examens_id) REFERENCES examens (id)');
        $this->addSql('ALTER TABLE eleves_classes ADD CONSTRAINT FK_68D087BC2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleves_classes ADD CONSTRAINT FK_68D087B9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examens ADD CONSTRAINT FK_B2E32DD7CABD5540 FOREIGN KEY (questionnaires_id) REFERENCES questionnaires (id)');
        $this->addSql('ALTER TABLE questionnaires_questions ADD CONSTRAINT FK_BC372841CABD5540 FOREIGN KEY (questionnaires_id) REFERENCES questionnaires (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_questions ADD CONSTRAINT FK_BC372841BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_classes ADD CONSTRAINT FK_8C5BE782CABD5540 FOREIGN KEY (questionnaires_id) REFERENCES questionnaires (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_classes ADD CONSTRAINT FK_8C5BE7829E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1F7AE0F1A');
        $this->addSql('ALTER TABLE eleves_classes DROP FOREIGN KEY FK_68D087BC2140342');
        $this->addSql('ALTER TABLE eleves_classes DROP FOREIGN KEY FK_68D087B9E225B24');
        $this->addSql('ALTER TABLE examens DROP FOREIGN KEY FK_B2E32DD7CABD5540');
        $this->addSql('ALTER TABLE questionnaires_questions DROP FOREIGN KEY FK_BC372841CABD5540');
        $this->addSql('ALTER TABLE questionnaires_questions DROP FOREIGN KEY FK_BC372841BCB134CE');
        $this->addSql('ALTER TABLE questionnaires_classes DROP FOREIGN KEY FK_8C5BE782CABD5540');
        $this->addSql('ALTER TABLE questionnaires_classes DROP FOREIGN KEY FK_8C5BE7829E225B24');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6BCB134CE');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE eleves');
        $this->addSql('DROP TABLE eleves_classes');
        $this->addSql('DROP TABLE examens');
        $this->addSql('DROP TABLE questionnaires');
        $this->addSql('DROP TABLE questionnaires_questions');
        $this->addSql('DROP TABLE questionnaires_classes');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE reponses_eleves');
    }
}
