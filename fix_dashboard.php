<?php
$lines = file('broken.txt');
$valid = [];
// $lines is 0-indexed.
// Line 118 is <?= $this->extend...
// Line 170 is <thead ...
foreach ($lines as $i => $line) {
    if ($i >= 118 && $i <= 170) {
        continue;
    }
    $valid[] = $line;
}
file_put_contents('app/Views/nonreg_dashboard.php', implode('', $valid));
echo "Fixed!\n";
