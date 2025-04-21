<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421133055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archivo_adjunto (id INT AUTO_INCREMENT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, nombre_archivo VARCHAR(255) NOT NULL, custom_path VARCHAR(255) DEFAULT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, INDEX IDX_80B2A751916B4D1A (id_usuario_creacion), INDEX IDX_80B2A7516A3D61BD (id_usuario_ultima_modificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, nombre VARCHAR(512) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', descripcion VARCHAR(512) DEFAULT NULL, codigo_interno INT DEFAULT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, INDEX IDX_8C0E9BD3916B4D1A (id_usuario_creacion), INDEX IDX_8C0E9BD36A3D61BD (id_usuario_ultima_modificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) DEFAULT NULL, cuit VARCHAR(20) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, last_seen DATETIME DEFAULT NULL, allow_password_change TINYINT(1) DEFAULT \'0\', login_attempts INT DEFAULT 0, habilitado TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), UNIQUE INDEX UNIQ_2265B05DB9BA4881 (cuit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_grupo (usuario_id INT NOT NULL, grupo_id INT NOT NULL, INDEX IDX_91D0F1CDDB38439E (usuario_id), INDEX IDX_91D0F1CD9C833003 (grupo_id), PRIMARY KEY(usuario_id, grupo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archivo_adjunto ADD CONSTRAINT FK_80B2A751916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE archivo_adjunto ADD CONSTRAINT FK_80B2A7516A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE grupo ADD CONSTRAINT FK_8C0E9BD3916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE grupo ADD CONSTRAINT FK_8C0E9BD36A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario_grupo ADD CONSTRAINT FK_91D0F1CDDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_grupo ADD CONSTRAINT FK_91D0F1CD9C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id) ON DELETE CASCADE');

        $this->addSql('CREATE TABLE sessions (sess_id varbinary(128) NOT NULL, sess_data blob NOT NULL, sess_lifetime int(10) UNSIGNED NOT NULL, sess_time int(10) UNSIGNED NOT NULL, user_id int(11) NULL DEFAULT NULL, user_ip varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL, PRIMARY KEY (sess_id) USING BTREE) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic');
        $this->addSql("CREATE VIEW view_usuario AS
            SELECT 
                u.id, 
                u.email, 
                ug.grupos, 
                u.habilitado,
                u.last_seen,
                IF(s.sess_lifetime IS NULL || UNIX_TIMESTAMP() > MAX(s.sess_lifetime), false, true) AS logueado, GROUP_CONCAT(CONCAT(CONVERT(s.sess_id,char), ':::', from_unixtime(s.sess_time, '%Y-%m-%d %H:%i:%s'), ':::', from_unixtime(s.sess_lifetime, '%Y-%m-%d %H:%i'), ':::', s.user_ip) ORDER BY s.sess_time DESC SEPARATOR '::::') AS sesiones
            FROM usuario u
            INNER JOIN (
                SELECT ug.usuario_id, GROUP_CONCAT(g.nombre SEPARATOR ', ') AS grupos
                FROM usuario_grupo ug
                INNER JOIN grupo g ON ug.grupo_id = g.id
                GROUP BY ug.usuario_id
            ) ug ON ug.usuario_id = u.id 
            LEFT JOIN sessions s ON s.user_id = u.id
            GROUP BY u.id");
        $this->addSql('INSERT INTO usuario(email, roles, password, habilitado) VALUES (\'admin@admin.com\', \'[]\', \'$argon2i$v=19$m=65536,t=4,p=1$bndNM2FhMVBCaVBxMTZ6TQ$fonPMryv73mTNbfLBOGh38T5Qy68HpZOOvHVp9Bp6Ho\', 1)');
        $this->addSql("INSERT INTO grupo(nombre, roles, descripcion) VALUES ('Administrador', '[\"ROLE_ALL\"]', 'Grupo para administrador')");
        $this->addSql('INSERT INTO usuario_grupo(usuario_id, grupo_id) VALUES (1, 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario_grupo DROP FOREIGN KEY FK_91D0F1CD9C833003');
        $this->addSql('ALTER TABLE archivo_adjunto DROP FOREIGN KEY FK_80B2A751916B4D1A');
        $this->addSql('ALTER TABLE archivo_adjunto DROP FOREIGN KEY FK_80B2A7516A3D61BD');
        $this->addSql('ALTER TABLE grupo DROP FOREIGN KEY FK_8C0E9BD3916B4D1A');
        $this->addSql('ALTER TABLE grupo DROP FOREIGN KEY FK_8C0E9BD36A3D61BD');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE usuario_grupo DROP FOREIGN KEY FK_91D0F1CDDB38439E');
        $this->addSql('DROP TABLE archivo_adjunto');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuario_grupo');
    }
}
