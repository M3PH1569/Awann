<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsSuperToAdmin extends Migration
{
    public function up()
    {
        $this->forge->addColumn('admin', [
            'is_super' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'unsigned'   => true,
                'after'      => 'password',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('admin', 'is_super');
    }
}
