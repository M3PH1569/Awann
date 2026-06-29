<?php
$host = '123.231.223.6';
$port = '5100';
$db = 'assetmanage';
$user = 'akp';
$pass = 'S3pt4@';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("UPDATE nodes SET site_sentral = SUBSTRING(node_sentral, 1, 6) WHERE node_sentral != '-' AND node_sentral IS NOT NULL");
    $pdo->exec("UPDATE nodes SET site_sentral = '-' WHERE node_sentral = '-' OR node_sentral IS NULL");
    echo "Backfilled site_sentral in nodes table.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
