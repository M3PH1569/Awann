<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $nama = [
            'Sandi',
            'Faizin',
            'Aryo',
            'Andre',
            'Anang',
            'Fahri',
            'Iqbal',
            'Nawal',
            'Adit',
            'Giri',
            'Albaskoro'
        ];

        $data=[];
        foreach($nama as $n){
            $data[]=['nama'=>$n];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
