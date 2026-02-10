<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class MutasiSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('mutasi')->insert([
            'id_perangkat'=>1,
            'id_users'=>1,
            'status'=>'Dibawa',
            'keterangan'=>'Alokasi PTIPBC',
            'created_at'   => Time::now(),
            'updated_at'   => Time::now(),
        ]);
    }
}
