<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703161831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_recipe_ingredient (ingredient_id INT NOT NULL, recipe_ingredient_id INT NOT NULL, INDEX IDX_FC5A4FF8933FE08C (ingredient_id), INDEX IDX_FC5A4FF83CAF64A (recipe_ingredient_id), PRIMARY KEY(ingredient_id, recipe_ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_DA88B13712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, quantity VARCHAR(255) NOT NULL, measured VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient_recipe (recipe_ingredient_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_E4BB99D23CAF64A (recipe_ingredient_id), INDEX IDX_E4BB99D259D8A214 (recipe_id), PRIMARY KEY(recipe_ingredient_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, steps_id INT NOT NULL, number_step INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_43B9FE3C1EBBD054 (steps_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_recipe_ingredient ADD CONSTRAINT FK_FC5A4FF8933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_recipe_ingredient ADD CONSTRAINT FK_FC5A4FF83CAF64A FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D23CAF64A FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C1EBBD054 FOREIGN KEY (steps_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13712469DE2');
        $this->addSql('ALTER TABLE ingredient_recipe_ingredient DROP FOREIGN KEY FK_FC5A4FF8933FE08C');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D259D8A214');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C1EBBD054');
        $this->addSql('ALTER TABLE ingredient_recipe_ingredient DROP FOREIGN KEY FK_FC5A4FF83CAF64A');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D23CAF64A');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_recipe_ingredient');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE recipe_ingredient_recipe');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE user');
    }
}
