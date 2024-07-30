<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicacionesTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE `publicaciones` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `publicacion` TEXT NULL,
                `fecha_creacion` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                `fecha_actualizacion` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `id_usuario` INT(11) NULL,
                PRIMARY KEY (`id`)
            );
        ");
    }

    public function down()
    {
        $this->forge->dropTable('publicaciones');
    }
}
