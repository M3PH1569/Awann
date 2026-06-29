<?php
$lines = file('app/Views/nonreg_dashboard.php');
$out = array_merge(array_slice($lines, 0, 91), array_slice($lines, 253));
file_put_contents('app/Views/nonreg_dashboard.php', implode('', $out));
