<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLicenciaToTipoPermisos extends Migration
{
    public function up()
    {
        // Insert the LICENCIA record into tipo_permisos table
        $this->db->table('tipo_permisos')->insert([
            'permiso' => 'LICENCIA'
        ]);
    }

    public function down()
    {
        // Remove the LICENCIA record when rolling back
        $this->db->table('tipo_permisos')
            ->where('permiso', 'LICENCIA')
            ->delete();
    }
}
