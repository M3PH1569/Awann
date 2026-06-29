<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSiteSentral extends Migration
{
    public function up()
    {
        $this->forge->addColumn('nodes', [
            'site_sentral' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'arep'
            ]
        ]);

        $this->forge->addColumn('installation_requests', [
            'site_sentral' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'arep'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('nodes', 'site_sentral');
        $this->forge->dropColumn('installation_requests', 'site_sentral');
    }
}
