<?php
try {
    $db = new PDO('pgsql:host=123.231.223.6;port=5100;dbname=assetmanage', 'akp', 'S3pt4@');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('ALTER TABLE return_requests ADD COLUMN IF NOT EXISTS is_read BOOLEAN DEFAULT FALSE');
    echo 'Done';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
