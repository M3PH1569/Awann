<?php
$conn = pg_connect("host=123.231.223.6 port=5100 dbname=assetmanage user=akp password=S3pt4@");
pg_query($conn, "ALTER TABLE mutasi ADD COLUMN is_read_admin BOOLEAN DEFAULT false NOT NULL");
pg_query($conn, "UPDATE mutasi SET is_read_admin = true");
echo "Done";
