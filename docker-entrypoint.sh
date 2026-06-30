#!/bin/bash
set -e

# Verifikasi Argon2ID tersedia di PHP
echo "Checking Argon2ID support..."
php -r "if (!defined('PASSWORD_ARGON2ID')) { echo 'ERROR: Argon2ID not supported!\n'; exit(1); } echo 'Argon2ID OK\n';"

# Run CodeIgniter migrations
echo "Running database migrations..."
php spark migrate --force

# Start Apache in the foreground
exec "$@"
