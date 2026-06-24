<?php
/**
 * One-time script to create BRP tables.
 * Run with: php create_brp_tables.php
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

use Config\Database;

$db = Database::connect();

// Create brp_counter table
echo "Creating brp_counter table...\n";
$sql1 = "CREATE TABLE IF NOT EXISTS brp_counter (
    id SERIAL PRIMARY KEY,
    period_month INTEGER NOT NULL,
    period_year INTEGER NOT NULL,
    last_number INTEGER NOT NULL DEFAULT 0,
    UNIQUE(period_month, period_year)
)";

if ($db->query($sql1)) {
    echo "brp_counter table created successfully.\n";
} else {
    echo "Error: " . print_r($db->error(), true) . "\n";
}

// Create brp_documents table
echo "Creating brp_documents table...\n";
$sql2 = "CREATE TABLE IF NOT EXISTS brp_documents (
    id SERIAL PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    generated_number INTEGER NOT NULL,
    period_month INTEGER NOT NULL,
    period_year INTEGER NOT NULL,
    mutasi_ids TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($db->query($sql2)) {
    echo "brp_documents table created successfully.\n";
} else {
    echo "Error: " . print_r($db->error(), true) . "\n";
}

echo "\nDone!\n";
