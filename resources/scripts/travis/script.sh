#!/usr/bin/env bash
set -euo pipefail

composer stan
curl -k -H "Accept: text/plain" https://security.symfony.com/check_lock -F lock=@composer.lock
./vendor/bin/phpunit --testdox --coverage-clover build/coverage.xml
