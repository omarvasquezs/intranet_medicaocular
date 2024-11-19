<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAmonestacionesTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE amonestaciones (
            id INT(11) NOT NULL AUTO_INCREMENT,
            id_usuario INT(11),
            sustentacion TEXT,
            fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
            fecha_inicio DATE,
            fecha_fin DATE,
            revisado_por INT(11),
            goce_haber BOOLEAN,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('amonestaciones');
    }
}
