<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFechaRetornoToAmonestaciones extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE amonestaciones ADD fecha_retorno DATE";

        $this->db->query($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE amonestaciones DROP COLUMN fecha_retorno";

        $this->db->query($sql);
    }
}
