<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $nama = [
            'Andhika Septa',
            'Sandiawan Izhart',
            'Khoerul Faizin',
            'Aryo Dewandaru',
            'Andre Pranata',
            'Anang Kiswantoro',
            'Rusdiantoro',
            'Maulana Fachri',
            'Iqbal Mustofa',
            'Gyo Prasetya',
            'Nawal Khazairy',
            'Yudi Yudianto',
            'Adhitya Gemeleonard',
            'Fachri Wardana',
            'Giri Mahendra',
            'Rizky Maulana',
            'Albaskoro',
            'EOS Habibullah',
            'EOS Kuncoro',
            'PPS Supriyadi',
            'PPS Erwin',
            'Catu Buana Fahrul',
            'Telkom Akses'
        ];

        $data=[];
        foreach($nama as $n){
            $data[]=['nama'=>$n];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
