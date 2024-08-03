<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPermisoTemporalToTipoPermisos extends Migration
{
    public function up()
    {
        // Insert a new row into the tipo_permisos table
        $this->db->table('tipo_permisos')->insert([
            'permiso' => 'PERMISO TEMPORAL'
        ]);
    }

    public function down()
    {
        // Remove the row from the tipo_permisos table
        $this->db->table('tipo_permisos')->where('permiso', 'PERMISO TEMPORAL')->delete();
    }
}
