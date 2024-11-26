<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyAdjuntoColumn extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('registro_permisos', [
            'adjunto' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('registro_permisos', [
            'adjunto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }
}
