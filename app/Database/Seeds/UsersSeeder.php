<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $nama = [
            'Sandiawan Izhart',
            'Khoerul Faizin',
            'Aryo Dewandaru',
            'Andre Pranata',
            'Anang Kiswantoro',
            'Maulana Fachri',
            'Iqbal Mustofa',
            'Nawal Haidan',
            'Yudi Yudianto',
            'Adhitya Gemeleonard',
            'Fachry',
            'Giri Mahendra',
            'Rizky Maulana',
            'Albaskoro',
            'Habib'
        ];

        $data=[];
        foreach($nama as $n){
            $data[]=['nama'=>$n];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
