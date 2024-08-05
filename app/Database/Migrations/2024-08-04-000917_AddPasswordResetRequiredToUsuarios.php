<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordResetRequiredToUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'password_reset_required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'pass', // Adjust the position as needed
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', 'password_reset_required');
    }
}
