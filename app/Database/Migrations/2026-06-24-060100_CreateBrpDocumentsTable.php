<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBrpDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'generated_number' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'period_month' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'period_year' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'mutasi_ids' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('brp_documents', true);
    }

    public function down()
    {
        $this->forge->dropTable('brp_documents');
    }
}
