#!/bin/bash
set -e

# Run CodeIgniter migrations
echo "Running database migrations..."
php spark migrate

# Start Apache in the foreground
exec "$@"
