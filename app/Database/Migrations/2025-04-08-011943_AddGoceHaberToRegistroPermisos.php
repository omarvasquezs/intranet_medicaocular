<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoceHaberToRegistroPermisos extends Migration
{
    public function up()
    {
        // Add goce_haber field to registro_permisos table
        // Similar to the one in amonestaciones table
        $this->forge->addColumn('registro_permisos', [
            'goce_haber' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'after'      => 'revisado_por'
            ]
        ]);
    }

    public function down()
    {
        // Drop the column if migration is rolled back
        $this->forge->dropColumn('registro_permisos', 'goce_haber');
    }
}
