#!/usr/bin/env bash

php bin/console etl:run ../app/Etl/area.xml
php bin/console etl:run ../app/Etl/partners.xml
php bin/console etl:run ../app/Etl/service.xml
php bin/console etl:run ../app/Etl/company.xml
php bin/console etl:run ../app/Etl/registry.xml
php bin/console etl:run ../app/Etl/myaudi.xml
php bin/console etl:run ../app/Etl/openingHourPartner.xml