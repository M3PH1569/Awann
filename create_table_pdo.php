<?php
$host = '123.231.223.6';
$port = '5100';
$dbname = 'assetmanage';
$user = 'akp';
$password = 'S3pt4@';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sql = "CREATE TABLE IF NOT EXISTS return_requests (
        id SERIAL PRIMARY KEY,
        id_mutasi INT NOT NULL,
        status VARCHAR(20) DEFAULT 'Pending',
        created_at TIMESTAMP,
        updated_at TIMESTAMP,
        CONSTRAINT fk_mutasi FOREIGN KEY (id_mutasi) REFERENCES mutasi(id) ON DELETE CASCADE
    );";

    $pdo->exec($sql);
    echo "Table created successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
