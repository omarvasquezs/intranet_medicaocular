<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addingboletafirmadafield extends Migration
{
    public function up()
    {
        $this->forge->addColumn('boletas', [
            'boleta_firmada' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true, // or false, depending on your requirements
                'default' => 1,    // or another default value
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('boletas', 'boleta_firmada');
    }
}
