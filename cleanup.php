<?php
$lines = file('c:/laragon/www/AssetManagement/app/Views/nonreg_dashboard.php');
file_put_contents('c:/laragon/www/AssetManagement/app/Views/nonreg_dashboard.php', implode('', array_slice($lines, 0, 345)) . "\n</script>\n\n" . '<?= $this->endSection() ?>' . "\n");
echo "Done.";
