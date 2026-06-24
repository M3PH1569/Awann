<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBrpCounterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'period_month' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'period_year' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'last_number' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['period_month', 'period_year']);
        $this->forge->createTable('brp_counter');
    }

    public function down()
    {
        $this->forge->dropTable('brp_counter');
    }
}
