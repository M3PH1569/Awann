<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateMutasiTableForNonReg extends Migration
{
    public function up()
    {
        $fields = [
            'id_non_reg' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_perangkat'
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
                'after'      => 'id_non_reg'
            ],
        ];
        
        $this->forge->addColumn('mutasi', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mutasi', 'id_non_reg');
        $this->forge->dropColumn('mutasi', 'qty');
    }
}
