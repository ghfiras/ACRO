<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513215714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE examen_question (examen_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_8A572DF85C8659A (examen_id), INDEX IDX_8A572DF81E27F6BF (question_id), PRIMARY KEY(examen_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passer_examen (id INT AUTO_INCREMENT NOT NULL, examen_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B15BF51F5C8659A (examen_id), INDEX IDX_B15BF51FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, passer_examen_id INT NOT NULL, qyestion_id INT NOT NULL, choix_id INT NOT NULL, INDEX IDX_5FB6DEC7E449BC48 (passer_examen_id), INDEX IDX_5FB6DEC741B1631 (qyestion_id), INDEX IDX_5FB6DEC7D9144651 (choix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT FK_8A572DF85C8659A FOREIGN KEY (examen_id) REFERENCES examen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen_question ADD CONSTRAINT FK_8A572DF81E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passer_examen ADD CONSTRAINT FK_B15BF51F5C8659A FOREIGN KEY (examen_id) REFERENCES examen (id)');
        $this->addSql('ALTER TABLE passer_examen ADD CONSTRAINT FK_B15BF51FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E449BC48 FOREIGN KEY (passer_examen_id) REFERENCES passer_examen (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC741B1631 FOREIGN KEY (qyestion_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7D9144651 FOREIGN KEY (choix_id) REFERENCES choix (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY FK_8A572DF85C8659A');
        $this->addSql('ALTER TABLE examen_question DROP FOREIGN KEY FK_8A572DF81E27F6BF');
        $this->addSql('ALTER TABLE passer_examen DROP FOREIGN KEY FK_B15BF51F5C8659A');
        $this->addSql('ALTER TABLE passer_examen DROP FOREIGN KEY FK_B15BF51FA76ED395');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E449BC48');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC741B1631');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7D9144651');
        $this->addSql('DROP TABLE examen_question');
        $this->addSql('DROP TABLE passer_examen');
        $this->addSql('DROP TABLE reponse');
    }
}
