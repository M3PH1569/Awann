<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $nama = [
            'Andhika Septa',
            'Khoerul Faizin',
            'Aryo Dewandaru',
            'Andre Pranata',
            'Anang Kiswantoro',
            'Rusdiantoro',
            'Maulana Fachri',
            'Iqbal Mustofa',
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
            'Catu Buana Technician',
            'Telkom Akses'
        ];

        $data=[];
        foreach($nama as $n){
            $data[]=['nama'=>$n];
        }
        
        // Get names that already exist in the database
        $existing = $this->db->table('users')
                             ->select('nama')
                             ->get()
                             ->getResultArray();
        $existingNames = array_column($existing, 'nama');

        // Only insert names that are not already in the table
        $newData = array_values(array_filter(
            $data,
            fn($row) => !in_array($row['nama'], $existingNames)
        ));

        if (!empty($newData)) {
            $this->db->table('users')->insertBatch($newData);
        }
    }
}
