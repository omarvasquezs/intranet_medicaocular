<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLicenciasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'sustentacion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'fecha_creacion' => [
                'type'    => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'fecha_inicio' => [
                'type' => 'DATE',
            ],
            'fecha_fin' => [
                'type' => 'DATE',
            ],
            'revisado_por' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'goce_haber' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);
        
        // Primary key
        $this->forge->addPrimaryKey('id');
        
        // Foreign keys can be added here if needed
        // $this->forge->addForeignKey('id_usuario', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('revisado_por', 'usuarios', 'id', 'SET NULL', 'CASCADE');
        
        // Create table
        $this->forge->createTable('licencias');
    }

    public function down()
    {
        // Drop table
        $this->forge->dropTable('licencias');
    }
}