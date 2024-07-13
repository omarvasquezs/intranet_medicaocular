<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyJefeColumnInUsuariosAndAreas extends Migration
{
    public function up()
    {
        // Add id_jefe to areas table
        $this->forge->addColumn('areas', [
            'id_jefe' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
        ]);

        // Remove id_jefe from usuarios table
        $this->forge->dropColumn('usuarios', 'id_jefe');
    }

    public function down()
    {
        // Remove id_jefe from areas table
        $this->forge->dropColumn('areas', 'id_jefe');

        // Add id_jefe back to usuarios table
        $this->forge->addColumn('usuarios', [
            'id_jefe' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
        ]);
    }
}
