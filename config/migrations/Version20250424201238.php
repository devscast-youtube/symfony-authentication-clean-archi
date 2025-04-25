<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20250424201238.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20250424201238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'database schema setup';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE login_attempt (id BINARY(16) NOT NULL COMMENT \'(DC2Type:login_attempt_id)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:user_id)\', created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_8C11C1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login_history (id BINARY(16) NOT NULL COMMENT \'(DC2Type:login_history_id)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:user_id)\', ip VARCHAR(45) DEFAULT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', device_operating_system VARCHAR(255) DEFAULT NULL, device_client VARCHAR(255) DEFAULT NULL, device_device VARCHAR(255) DEFAULT NULL, device_is_bot TINYINT(1) DEFAULT 0 NOT NULL, location_time_zone VARCHAR(255) DEFAULT NULL, location_longitude DOUBLE PRECISION DEFAULT NULL, location_latitude DOUBLE PRECISION DEFAULT NULL, location_accuracy_radius INT DEFAULT NULL, INDEX IDX_37976E36A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id BINARY(16) NOT NULL COMMENT \'(DC2Type:student_id)\', email VARCHAR(500) NOT NULL, birthdate DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', username_value TINYTEXT NOT NULL, city TINYTEXT NOT NULL, country TINYTEXT NOT NULL, address_line1 TINYTEXT NOT NULL, address_line2 TINYTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:user_id)\', name VARCHAR(255) NOT NULL, email VARCHAR(500) NOT NULL, password VARCHAR(4098) NOT NULL, is_locked TINYINT(1) DEFAULT 0 NOT NULL, is_confirmed TINYINT(1) DEFAULT 0 NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', roles JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE verification_token (id BINARY(16) NOT NULL COMMENT \'(DC2Type:verification_token_id)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:user_id)\', purpose VARCHAR(255) NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', token VARCHAR(255) DEFAULT NULL, INDEX IDX_C1CC006BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE login_attempt ADD CONSTRAINT FK_8C11C1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE login_history ADD CONSTRAINT FK_37976E36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verification_token ADD CONSTRAINT FK_C1CC006BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE login_attempt DROP FOREIGN KEY FK_8C11C1BA76ED395');
        $this->addSql('ALTER TABLE login_history DROP FOREIGN KEY FK_37976E36A76ED395');
        $this->addSql('ALTER TABLE verification_token DROP FOREIGN KEY FK_C1CC006BA76ED395');
        $this->addSql('DROP TABLE login_attempt');
        $this->addSql('DROP TABLE login_history');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE verification_token');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
