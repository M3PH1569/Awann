<?php
$pdo = new PDO('pgsql:host=123.231.223.6;port=5100;dbname=assetmanage', 'akp', 'S3pt4@');
$pdo->exec("UPDATE nodes SET site_sentral = SUBSTRING(node_sentral FROM 1 FOR 6) WHERE (site_sentral IS NULL OR site_sentral = '-') AND LENGTH(node_sentral) >= 6");
echo "Done\n";
