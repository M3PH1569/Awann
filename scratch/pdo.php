<?php
$host = '123.231.223.6';
$db = 'assetmanage';
$user = 'akp';
$pass = 'S3pt4@';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("ALTER TABLE nodes ADD COLUMN IF NOT EXISTS site_sentral VARCHAR(100) NULL");
    echo "Added site_sentral to nodes table.\n";

    $pdo->exec("ALTER TABLE installation_requests ADD COLUMN IF NOT EXISTS site_sentral VARCHAR(100) NULL");
    echo "Added site_sentral to installation_requests table.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
