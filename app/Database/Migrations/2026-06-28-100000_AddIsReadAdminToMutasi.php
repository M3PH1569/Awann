<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsReadAdminToMutasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mutasi', [
            'is_read_admin' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
            ],
        ]);
        
        // Default existing Dibawa to true so they don't show up
        $db = \Config\Database::connect();
        $db->table('mutasi')->where('status', 'Dibawa')->update(['is_read_admin' => true]);
    }

    public function down()
    {
        $this->forge->dropColumn('mutasi', 'is_read_admin');
    }
}
