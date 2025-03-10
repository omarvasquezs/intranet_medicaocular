<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_usuario_doc_firma' => 5,
        ];

        // Insert the record
        $this->db->table('configuracion')->insert($data);
    }
}
