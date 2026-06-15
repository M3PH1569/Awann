<?php
$pdo = new PDO('pgsql:host=123.231.223.6;port=5100;dbname=assetmanage', 'akp', 'S3pt4@', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$pdo->exec("ALTER TABLE mutasi ADD COLUMN IF NOT EXISTS updated_by VARCHAR(255) DEFAULT 'admin';");
$pdo->exec("UPDATE mutasi SET updated_by = 'admin' WHERE updated_by IS NULL;");
echo "Done\n";
