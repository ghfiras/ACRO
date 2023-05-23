<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514013035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY examen_question_ibfk_1');
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY examen_question_ibfk_2');
        $this->addSql('DROP INDEX `primary` ON examen_question');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT FK_8A572DF85C8659A FOREIGN KEY (examen_id) REFERENCES examen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT FK_8A572DF81E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen_question ADD PRIMARY KEY (examen_id, question_id)');
        $this->addSql('ALTER TABLE examen_question RENAME INDEX examen_id TO IDX_8A572DF85C8659A');
        $this->addSql('ALTER TABLE reponse CHANGE choix_id choix_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse CHANGE choix_id choix_id INT NOT NULL');
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY FK_8A572DF85C8659A');
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY FK_8A572DF81E27F6BF');
        $this->addSql('DROP INDEX `PRIMARY` ON examen_question');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT examen_question_ibfk_1 FOREIGN KEY (examen_id) REFERENCES examen (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT examen_question_ibfk_2 FOREIGN KEY (question_id) REFERENCES question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE examen_question ADD PRIMARY KEY (question_id, examen_id)');
        $this->addSql('ALTER TABLE examen_question RENAME INDEX idx_8a572df85c8659a TO examen_id');
    }
}
