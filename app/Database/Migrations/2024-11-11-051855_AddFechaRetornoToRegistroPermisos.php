<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFechaRetornoToRegistroPermisos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('registro_permisos', [
            'fecha_retorno' => [
                'type' => 'date',
                'null' => true,
                'after' => 'fecha_fin'
            ]
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('registro_permisos', 'fecha_retorno');
    }
}
