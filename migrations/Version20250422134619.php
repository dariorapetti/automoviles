<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422134619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, razon_social VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, comentario VARCHAR(200) DEFAULT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, INDEX IDX_F41C9B25916B4D1A (id_usuario_creacion), INDEX IDX_F41C9B256A3D61BD (id_usuario_ultima_modificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marca (id INT AUTO_INCREMENT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, INDEX IDX_70A0113916B4D1A (id_usuario_creacion), INDEX IDX_70A01136A3D61BD (id_usuario_ultima_modificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proveedor (id INT AUTO_INCREMENT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, razon_social VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, telefono_operador VARCHAR(255) NOT NULL, comentario VARCHAR(200) DEFAULT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, INDEX IDX_16C068CE916B4D1A (id_usuario_creacion), INDEX IDX_16C068CE6A3D61BD (id_usuario_ultima_modificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehiculo (id INT AUTO_INCREMENT NOT NULL, id_marca INT NOT NULL, id_usuario_creacion INT DEFAULT NULL, id_usuario_ultima_modificacion INT DEFAULT NULL, id_proveedor INT DEFAULT NULL, id_cliente INT DEFAULT NULL, dominio VARCHAR(255) NOT NULL, modelo VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, numero_motor VARCHAR(255) NOT NULL, numero_chasis VARCHAR(255) NOT NULL, cotizacion_dolar NUMERIC(10, 2) NOT NULL, fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_ultima_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, fecha_baja DATETIME DEFAULT NULL, discriminador VARCHAR(255) NOT NULL, anio INT DEFAULT NULL, kilometros INT DEFAULT NULL, precio_compra_usd NUMERIC(10, 2) NOT NULL, precio_venta_usd NUMERIC(10, 2) NOT NULL, precio_compra_pesos NUMERIC(10, 2) NOT NULL, precio_venta_pesos NUMERIC(10, 2) NOT NULL, precio_revista NUMERIC(10, 2) DEFAULT NULL, kit_seguridad TINYINT(1) DEFAULT NULL, cubre_alfombras TINYINT(1) DEFAULT NULL, titulo TINYINT(1) DEFAULT NULL, cedula_verde TINYINT(1) DEFAULT NULL, formulario08 TINYINT(1) DEFAULT NULL, grabado_autopartes TINYINT(1) DEFAULT NULL, duplicado_llaves TINYINT(1) DEFAULT NULL, vencimiento_gnc DATE DEFAULT NULL, vencimiento_vtv DATE DEFAULT NULL, informe_dominio VARCHAR(255) DEFAULT NULL, patentes VARCHAR(255) DEFAULT NULL, comentario VARCHAR(200) DEFAULT NULL, INDEX IDX_C9FA1603E98F4023 (id_marca), INDEX IDX_C9FA1603916B4D1A (id_usuario_creacion), INDEX IDX_C9FA16036A3D61BD (id_usuario_ultima_modificacion), INDEX IDX_C9FA160396F5D4E9 (id_proveedor), INDEX IDX_C9FA1603DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B256A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE marca ADD CONSTRAINT FK_70A0113916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE marca ADD CONSTRAINT FK_70A01136A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE proveedor ADD CONSTRAINT FK_16C068CE916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE proveedor ADD CONSTRAINT FK_16C068CE6A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE vehiculo ADD CONSTRAINT FK_C9FA1603E98F4023 FOREIGN KEY (id_marca) REFERENCES marca (id)');
        $this->addSql('ALTER TABLE vehiculo ADD CONSTRAINT FK_C9FA1603916B4D1A FOREIGN KEY (id_usuario_creacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE vehiculo ADD CONSTRAINT FK_C9FA16036A3D61BD FOREIGN KEY (id_usuario_ultima_modificacion) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE vehiculo ADD CONSTRAINT FK_C9FA160396F5D4E9 FOREIGN KEY (id_proveedor) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE vehiculo ADD CONSTRAINT FK_C9FA1603DE734E51 FOREIGN KEY (id_cliente) REFERENCES cliente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehiculo DROP FOREIGN KEY FK_C9FA1603DE734E51');
        $this->addSql('ALTER TABLE vehiculo DROP FOREIGN KEY FK_C9FA1603E98F4023');
        $this->addSql('ALTER TABLE vehiculo DROP FOREIGN KEY FK_C9FA160396F5D4E9');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE marca');
        $this->addSql('DROP TABLE proveedor');
        $this->addSql('DROP TABLE vehiculo');
    }
}
