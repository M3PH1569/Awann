<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PerangkatSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(WRITEPATH . 'uploads/cobalagi.csv', 'r');
        $data = [];
        $header = fgetcsv($file);


        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            $data[] = [
                'nama' => $row[0],
                'noreg' => $row[1],
                'status' => 'Tersedia',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        fclose($file);

        $this->db->table('perangkat')->insertBatch($data);
    }
}
