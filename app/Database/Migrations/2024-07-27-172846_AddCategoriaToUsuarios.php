<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoriaToUsuarios extends Migration
{
    public function up()
    {
        $fields = [
            'categoria' => [
                'type' => 'ENUM',
                'constraint' => ['I', 'E'],
                'null' => false,
                'default' => 'I',
                'comment' => 'Categoria can be I or E'
            ]
        ];

        $this->forge->addColumn('usuarios', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', 'categoria');
    }
}
