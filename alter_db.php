<?php
try {
    $pdo = new PDO('pgsql:host=123.231.223.6;port=5100;dbname=assetmanage', 'akp', 'S3pt4@');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('ALTER TABLE mutasi ALTER COLUMN id_perangkat DROP NOT NULL');
    echo "Database updated successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
