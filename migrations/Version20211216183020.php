<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216183020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customisation DROP FOREIGN KEY FK_8C0C380E288CFCBD');
        $this->addSql('ALTER TABLE customisation ADD CONSTRAINT FK_8C0C380E288CFCBD FOREIGN KEY (presentation_article_id) REFERENCES article (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customisation DROP FOREIGN KEY FK_8C0C380E288CFCBD');
        $this->addSql('ALTER TABLE customisation ADD CONSTRAINT FK_8C0C380E288CFCBD FOREIGN KEY (presentation_article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
