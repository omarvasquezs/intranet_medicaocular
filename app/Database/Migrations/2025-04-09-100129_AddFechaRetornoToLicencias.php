<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFechaRetornoToLicencias extends Migration
{
    public function up()
    {
        $this->forge->addColumn('licencias', [
            'fecha_retorno' => [
                'type'       => 'DATE',
                'null'       => true,
                'after'      => 'fecha_fin'
            ],
            'observaciones' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'goce_haber'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('licencias', 'fecha_retorno');
        $this->forge->dropColumn('licencias', 'observaciones');
    }
}
