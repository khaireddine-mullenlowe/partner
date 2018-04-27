#!/bin/sh
#
# If DB schema has changed then launch migration process again

php bin/console doctrine:schema:validate --env=prod --quiet

if [ $? -ne 0 ]; then
    bin/migrate.sh
fi
