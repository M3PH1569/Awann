<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

use Config\Database;

$db = Database::connect();

$sql = "CREATE TABLE IF NOT EXISTS return_requests (
    id SERIAL PRIMARY KEY,
    id_mutasi INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT fk_mutasi FOREIGN KEY (id_mutasi) REFERENCES mutasi(id) ON DELETE CASCADE
);";

if ($db->query($sql)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . print_r($db->error(), true);
}
