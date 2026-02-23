<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260223150804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cita (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, hora_inicio TIME NOT NULL, duracion VARCHAR(50) NOT NULL, estado VARCHAR(50) NOT NULL, paciente_id INT NOT NULL, odontologo_id INT NOT NULL, box_id INT NOT NULL, INDEX IDX_3E379A627310DAD4 (paciente_id), INDEX IDX_3E379A62C1C6A359 (odontologo_id), INDEX IDX_3E379A62D8177B3F (box_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE odontograma (id INT AUTO_INCREMENT NOT NULL, dientes JSON NOT NULL, paciente_id INT NOT NULL, INDEX IDX_9E4EE42A7310DAD4 (paciente_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE odontologo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, especialidad VARCHAR(255) DEFAULT NULL, dia_semana_asignado VARCHAR(50) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE paciente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, dni VARCHAR(20) NOT NULL, numero_seguridad_social VARCHAR(255) DEFAULT NULL, telefono VARCHAR(20) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, alergias JSON DEFAULT NULL, enfermedades VARCHAR(255) DEFAULT NULL, historial_clinico LONGTEXT DEFAULT NULL, datos_facturacion VARCHAR(255) DEFAULT NULL, fecha_creacion DATETIME NOT NULL, fecha_modificacion DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE primera_visita (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, motivo_consulta LONGTEXT DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, paciente_id INT NOT NULL, odontograma_inicial_id INT DEFAULT NULL, INDEX IDX_E9B37AF67310DAD4 (paciente_id), INDEX IDX_E9B37AF659515092 (odontograma_inicial_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE protocolo_tratamiento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, material_necesario VARCHAR(255) DEFAULT NULL, cantidad NUMERIC(10, 2) DEFAULT NULL, estado VARCHAR(50) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE radiografia (id INT AUTO_INCREMENT NOT NULL, nombre_archivo VARCHAR(255) NOT NULL, tipo_radiografia VARCHAR(100) DEFAULT NULL, fecha_subida DATETIME NOT NULL, observaciones LONGTEXT DEFAULT NULL, paciente_id INT NOT NULL, INDEX IDX_9790483D7310DAD4 (paciente_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recepcion_material (id INT AUTO_INCREMENT NOT NULL, cantidad NUMERIC(10, 2) NOT NULL, proveedor VARCHAR(255) DEFAULT NULL, fecha DATETIME NOT NULL, material_id INT NOT NULL, INDEX IDX_19046833E308AC6F (material_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE stock_material (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, cantidad NUMERIC(10, 2) NOT NULL, unidad VARCHAR(50) NOT NULL, fecha_ultima_reposicion DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tratamiento (id INT AUTO_INCREMENT NOT NULL, diente VARCHAR(50) NOT NULL, cara VARCHAR(50) DEFAULT NULL, tipo_tratamiento VARCHAR(255) NOT NULL, estado VARCHAR(50) NOT NULL, color VARCHAR(50) DEFAULT NULL, fecha DATETIME NOT NULL, odontograma_id INT NOT NULL, INDEX IDX_61A4A07CF8ED5CE7 (odontograma_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A627310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A62C1C6A359 FOREIGN KEY (odontologo_id) REFERENCES odontologo (id)');
        $this->addSql('ALTER TABLE cita ADD CONSTRAINT FK_3E379A62D8177B3F FOREIGN KEY (box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE odontograma ADD CONSTRAINT FK_9E4EE42A7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE primera_visita ADD CONSTRAINT FK_E9B37AF67310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE primera_visita ADD CONSTRAINT FK_E9B37AF659515092 FOREIGN KEY (odontograma_inicial_id) REFERENCES odontograma (id)');
        $this->addSql('ALTER TABLE radiografia ADD CONSTRAINT FK_9790483D7310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recepcion_material ADD CONSTRAINT FK_19046833E308AC6F FOREIGN KEY (material_id) REFERENCES stock_material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07CF8ED5CE7 FOREIGN KEY (odontograma_id) REFERENCES odontograma (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A627310DAD4');
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A62C1C6A359');
        $this->addSql('ALTER TABLE cita DROP FOREIGN KEY FK_3E379A62D8177B3F');
        $this->addSql('ALTER TABLE odontograma DROP FOREIGN KEY FK_9E4EE42A7310DAD4');
        $this->addSql('ALTER TABLE primera_visita DROP FOREIGN KEY FK_E9B37AF67310DAD4');
        $this->addSql('ALTER TABLE primera_visita DROP FOREIGN KEY FK_E9B37AF659515092');
        $this->addSql('ALTER TABLE radiografia DROP FOREIGN KEY FK_9790483D7310DAD4');
        $this->addSql('ALTER TABLE recepcion_material DROP FOREIGN KEY FK_19046833E308AC6F');
        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07CF8ED5CE7');
        $this->addSql('DROP TABLE box');
        $this->addSql('DROP TABLE cita');
        $this->addSql('DROP TABLE odontograma');
        $this->addSql('DROP TABLE odontologo');
        $this->addSql('DROP TABLE paciente');
        $this->addSql('DROP TABLE primera_visita');
        $this->addSql('DROP TABLE protocolo_tratamiento');
        $this->addSql('DROP TABLE radiografia');
        $this->addSql('DROP TABLE recepcion_material');
        $this->addSql('DROP TABLE stock_material');
        $this->addSql('DROP TABLE tratamiento');
    }
}
