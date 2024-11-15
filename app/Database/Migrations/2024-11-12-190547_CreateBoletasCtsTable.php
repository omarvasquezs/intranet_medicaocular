<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBoletasCtsTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        $sql = "
            CREATE TABLE `boletas_cts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_usuario` int(11) DEFAULT NULL,
                `adjunto` varchar(255) DEFAULT NULL,
                `id_estado_boleta` int(11) DEFAULT NULL,
                `subido_por` int(11) DEFAULT NULL,
                `revisado_por` int(11) DEFAULT NULL,
                `fecha_creacion` datetime DEFAULT current_timestamp(),
                `fecha_modificacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                `observaciones` text DEFAULT NULL,
                `boleta_firmada` tinyint(1) DEFAULT 1,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";

        $db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('boletas_cts');
    }
}
