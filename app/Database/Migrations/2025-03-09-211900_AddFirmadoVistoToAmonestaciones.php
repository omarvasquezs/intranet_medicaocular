<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFirmadoVistoToAmonestaciones extends Migration
{
    public function up()
    {
        // Modify the goce_haber column to be not null
        $this->forge->modifyColumn('amonestaciones', [
            'goce_haber' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false
            ]
        ]);

        // Add new columns firmado and visto
        $this->forge->addColumn('amonestaciones', [
            'firmado' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
                'after'      => 'goce_haber',
                'comment'    => 'Indicates if the document has been signed'
            ],
            'visto' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
                'after'      => 'firmado',
                'comment'    => 'Indicates if the document has been viewed'
            ]
        ]);
    }

    public function down()
    {
        // Drop the columns firmado and visto
        $this->forge->dropColumn('amonestaciones', 'firmado');
        $this->forge->dropColumn('amonestaciones', 'visto');

        // Revert the goce_haber column to allow null
        $this->forge->modifyColumn('amonestaciones', [
            'goce_haber' => [
                'type'       => 'BOOLEAN',
                'null'       => true,
                'default'    => null
            ]
        ]);
    }
}
