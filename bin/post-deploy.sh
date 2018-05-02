#!/bin/sh
#
# If DB schema has changed then launch migration process again

php bin/console doctrine:schema:validate --env=prod --quiet

if [ $? -ne 0 ] && [ -f "bin/migrate.sh" ]; then
    sh bin/migrate.sh
fi
