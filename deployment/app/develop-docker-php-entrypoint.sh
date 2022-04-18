#!/usr/bin/env sh
set -e

composer install --prefer-dist

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php "$@"
fi

exec "$@"
