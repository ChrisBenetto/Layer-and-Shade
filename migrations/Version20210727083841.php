<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210727083841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, author_id INT NOT NULL, figurine_id INT NOT NULL, content TEXT NOT NULL, create_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526CC550FC1B ON comment (figurine_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC550FC1B FOREIGN KEY (figurine_id) REFERENCES figurine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE figurine ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE figurine ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE figurine ADD CONSTRAINT FK_9DD64787E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE figurine ADD CONSTRAINT FK_9DD647812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9DD64787E3C61F9 ON figurine (owner_id)');
        $this->addSql('CREATE INDEX IDX_9DD647812469DE2 ON figurine (category_id)');
        $this->addSql('ALTER TABLE picture ADD figurine_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89C550FC1B FOREIGN KEY (figurine_id) REFERENCES figurine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_16DB4F89C550FC1B ON picture (figurine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE figurine DROP CONSTRAINT FK_9DD64787E3C61F9');
        $this->addSql('ALTER TABLE figurine DROP CONSTRAINT FK_9DD647812469DE2');
        $this->addSql('DROP INDEX IDX_9DD64787E3C61F9');
        $this->addSql('DROP INDEX IDX_9DD647812469DE2');
        $this->addSql('ALTER TABLE figurine DROP owner_id');
        $this->addSql('ALTER TABLE figurine DROP category_id');
        $this->addSql('ALTER TABLE picture DROP CONSTRAINT FK_16DB4F89C550FC1B');
        $this->addSql('DROP INDEX IDX_16DB4F89C550FC1B');
        $this->addSql('ALTER TABLE picture DROP figurine_id');
    }
}
