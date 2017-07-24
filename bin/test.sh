#!/usr/bin/env bash

php bin/console doctrine:fixtures:load --env=test --no-interaction
#
sqlite3 tests/_data/test.sqlite .dump  > tests/_data/test.sql
#
php vendor/bin/codecept run #--coverage --coverage-html