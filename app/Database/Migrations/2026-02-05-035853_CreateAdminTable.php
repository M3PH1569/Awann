<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'nama'=>[
                'type'=>'VARCHAR',
                'constraint'=> 100,
            ],
            'username'=>[
                'type'=>'VARCHAR',
                'constraint'=> 50,
            ],
            'password'=>[
                'type'=>'VARCHAR',
                'constraint'=> 255,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['username']);
        $this->forge->createTable('admin', true);
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
