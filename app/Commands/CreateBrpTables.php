<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateBrpTables extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'brp:create-tables';
    protected $description = 'Create BRP counter and documents tables';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('Creating brp_counter table...', 'yellow');
        try {
            $db->query("CREATE TABLE IF NOT EXISTS brp_counter (
                id SERIAL PRIMARY KEY,
                period_month INTEGER NOT NULL,
                period_year INTEGER NOT NULL,
                last_number INTEGER NOT NULL DEFAULT 0,
                UNIQUE(period_month, period_year)
            )");
            CLI::write('brp_counter table created successfully.', 'green');
        } catch (\Exception $e) {
            CLI::write('brp_counter error: ' . $e->getMessage(), 'red');
        }

        CLI::write('Creating brp_documents table...', 'yellow');
        try {
            $db->query("CREATE TABLE IF NOT EXISTS brp_documents (
                id SERIAL PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                user_name VARCHAR(255) NOT NULL,
                generated_number INTEGER NOT NULL,
                period_month INTEGER NOT NULL,
                period_year INTEGER NOT NULL,
                mutasi_ids TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            CLI::write('brp_documents table created successfully.', 'green');
        } catch (\Exception $e) {
            CLI::write('brp_documents error: ' . $e->getMessage(), 'red');
        }

        CLI::write('Done!', 'green');
    }
}
