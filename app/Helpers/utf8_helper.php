<?php

/**
 * @param string|null $str
 * @return string
 */
function sanitize_utf8(?string $str): string
{
    if ($str === null || $str === '') {
        return '';
    }
    $str = quoted_printable_decode($str);
    $str = str_replace("\xC2\xA0", ' ', $str);
    $str = str_replace("\xA0", ' ', $str);
    $str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');

    return $str;
}
