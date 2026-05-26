<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('admin')->insert([
            'nama'=>'admin',
            'username'=>'admin',
            'password'=>password_hash('admin123', PASSWORD_DEFAULT),
            'is_super'=>1,
            'created_at'=>Time::now(),
            'updated_at'=>Time::now(),
        ]);
    }
}
