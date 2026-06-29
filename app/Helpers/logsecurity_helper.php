<?php
if (!function_exists('log_security')) {
    function sanitizeLog(string $input): string 
    {
        $cleaned = str_replace(["\r", "\n", "%0d", "%0a", "%0d%0a"], "", $input);
        $cleaned = strip_tags($cleaned);
        return $cleaned;
    }
}


?>