<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsReadToReturnRequests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('return_requests', [
            'is_read' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'status'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('return_requests', 'is_read');
    }
}
