<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateIdJefeInAreas extends Migration
{
    public function up()
    {
        // Update id_jefe to 38 in areas table
        $this->db->table('areas')
                 ->update(['id_jefe' => 38]);
    }

    public function down()
    {
        // Optional: Define how to revert the update if necessary
        // For example, setting id_jefe back to a previous value or NULL
        // This is highly dependent on your application's requirements
    }
}