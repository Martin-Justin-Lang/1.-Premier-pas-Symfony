<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527212036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY season_ibfk_1');
        $this->addSql('DROP TABLE program_category');
        $this->addSql('DROP TABLE program_season');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_category (program_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_8779E5F412469DE2 (category_id), INDEX IDX_8779E5F43EB8070A (program_id), PRIMARY KEY(program_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE program_season (program_id INT NOT NULL, season_id INT NOT NULL, INDEX IDX_A4A465F33EB8070A (program_id), INDEX IDX_A4A465F34EC001D1 (season_id), PRIMARY KEY(program_id, season_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F43EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_season ADD CONSTRAINT FK_A4A465F33EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_season ADD CONSTRAINT FK_A4A465F34EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT season_ibfk_1 FOREIGN KEY (id) REFERENCES program_season (season_id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
