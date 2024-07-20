<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BoletasDatesAutomationDB extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `boletas` 
                CHANGE COLUMN `fecha_creacion` `fecha_creacion` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
                CHANGE COLUMN `fecha_modificacion` `fecha_modificacion` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP();";
        $this->db->query($sql);
    }

    public function down()
    {
        // Revert the changes made in the up() method. This might involve setting the columns back to their original state.
        // Note: Adjust the below SQL based on the original state of your columns before the migration.
        $sql = "ALTER TABLE `boletas` 
                CHANGE COLUMN `fecha_creacion` `fecha_creacion` DATETIME NULL,
                CHANGE COLUMN `fecha_modificacion` `fecha_modificacion` DATETIME NULL;";
        $this->db->query($sql);
    }
}
