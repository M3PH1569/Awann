<?php
define('FCPATH', __DIR__);
chdir(__DIR__ . '/../');
require 'vendor/autoload.php';
$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

try {
    $db->query("ALTER TABLE nodes ADD COLUMN site_sentral VARCHAR(100) NULL");
    echo "Added site_sentral to nodes table.\n";
} catch (\Exception $e) {
    echo "nodes table: " . $e->getMessage() . "\n";
}

try {
    $db->query("ALTER TABLE installation_requests ADD COLUMN site_sentral VARCHAR(100) NULL");
    echo "Added site_sentral to installation_requests table.\n";
} catch (\Exception $e) {
    echo "installation_requests table: " . $e->getMessage() . "\n";
}
