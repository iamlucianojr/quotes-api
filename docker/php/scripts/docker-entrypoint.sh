#!/bin/bash
set -e

echo "Initializing the docker entry point"

if [[ "${1#-}" != "$1" ]]; then
  set -- php-fpm "$@"
fi

exec "$@"
