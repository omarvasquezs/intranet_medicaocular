<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVistoField extends Migration
{
    public function up()
    {
        // Add visto field to boletas table
        $this->forge->addColumn('boletas', [
            'visto' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
                'after'      => 'boleta_firmada'
            ]
        ]);

        // Add visto field to boletas_cts table
        $this->forge->addColumn('boletas_cts', [
            'visto' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
                'after'      => 'boleta_firmada'
            ]
        ]);
    }

    public function down()
    {
        // Remove visto field from boletas table
        $this->forge->dropColumn('boletas', 'visto');
        
        // Remove visto field from boletas_cts table
        $this->forge->dropColumn('boletas_cts', 'visto');
    }
}
