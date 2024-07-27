<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDniColumnInUsuarios extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('usuarios', [
            'dni' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('usuarios', [
            'dni' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
    }
}
