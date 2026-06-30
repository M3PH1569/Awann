<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AdminSeeder extends Seeder
{
    public function run()
    {
        helper('password');
        $this->db->table('admin')->insert([
            'nama'       => 'admin',
            'username'   => 'admin',
            // [SECURITY] Argon2ID — admin wajib ganti password saat pertama login
            'password'   => hash_password('admin123'),
            'is_super'   => 1,
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ]);
    }
}
