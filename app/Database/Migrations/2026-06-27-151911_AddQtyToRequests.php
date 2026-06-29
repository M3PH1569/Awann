<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQtyToRequests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('return_requests', [
            'qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addColumn('installation_requests', [
            'qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('return_requests', 'qty');
        $this->forge->dropColumn('installation_requests', 'qty');
    }
}
