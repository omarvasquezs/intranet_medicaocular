<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveLicenciaPermission extends Migration
{
    public function up()
    {
        // Delete the "licencia" permission type (ID 6)
        $this->db->query("DELETE FROM tipo_permisos WHERE id = 6");
        
        // Reset the AUTO_INCREMENT value to 6
        $this->db->query("ALTER TABLE tipo_permisos AUTO_INCREMENT = 6");
    }

    public function down()
    {
        // In case we need to rollback, we'd re-insert the record
        // Note: This assumes the record existed with these values
        $this->db->table('tipo_permisos')->insert([
            'id' => 6,
            'permiso' => 'LICENCIA',
            'descripcion' => 'Licencia'
        ]);
    }
}
