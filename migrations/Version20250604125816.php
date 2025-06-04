<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604125816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE event_attendee (event_id INT NOT NULL, attendee_id INT NOT NULL, INDEX IDX_57BC3CB771F7E88B (event_id), INDEX IDX_57BC3CB7BCFD782A (attendee_id), PRIMARY KEY(event_id, attendee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_attendee ADD CONSTRAINT FK_57BC3CB771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_attendee ADD CONSTRAINT FK_57BC3CB7BCFD782A FOREIGN KEY (attendee_id) REFERENCES attendee (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD category_id INT DEFAULT NULL, ADD organizer_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3BAE0AA7876C4DDA ON event (organizer_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event_attendee DROP FOREIGN KEY FK_57BC3CB771F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_attendee DROP FOREIGN KEY FK_57BC3CB7BCFD782A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_attendee
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7876C4DDA
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3BAE0AA712469DE2 ON event
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_3BAE0AA7876C4DDA ON event
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP category_id, DROP organizer_id
        SQL);
    }
}
