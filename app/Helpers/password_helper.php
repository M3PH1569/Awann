<?php

const ARGON2_OPTIONS = [
    'memory_cost' => 65536, // 64 MB
    'time_cost'   => 3,
    'threads'     => 2,
];

/**
 * @param string $password Password plaintext
 * @return string Hash Argon2ID
 */
if (!function_exists('hash_password')) {
    function hash_password(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, ARGON2_OPTIONS);
    }
}

/**
 * @param string $password Password plaintext
 * @param string $hash     Hash dari database
 * @return bool
 */
if (!function_exists('verify_password')) {
    function verify_password(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

/**
 * @param string $hash Hash dari database
 * @return bool true jika perlu rehash
 */
if (!function_exists('password_needs_upgrade')) {
    function password_needs_upgrade(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_ARGON2ID, ARGON2_OPTIONS);
    }
}
