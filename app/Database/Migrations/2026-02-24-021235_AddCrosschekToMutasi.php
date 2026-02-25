<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use DateTime;

class AddCrosschekToMutasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mutasi', [
            'is_checked'=>[
                'type'=>'TINYINT',
                'constraint'=>1,
                'default'=>0,
                'unsigned'=>true,
                'after'=>'keterangan',
            ],
            'checked_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
                'after'=>'is_checked',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mutasi', ['is_checked', 'checked_at']);
    }
}
