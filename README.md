# audi-agc5-partner

## Configuration Supervisor pour injection des données myAudi
```
[program:rabbitmq-audi-user-update-partner]
command=/var/www/audi-agc5-partner/bin/console rabbitmq:consumer myaudi_user_create_or_update_partner
stdout_logfile=/var/log/supervisor/%(program_name)s.log
stderr_logfile=/var/log/supervisor/%(program_name)s.log
autostart=true
```


## Tests & Documentation :
### Tests codeception

Excecute the following commande :
``` bash
./vendor/bin/codecept run --coverage-html coverage
```

The coverage is readable in HTML format in tests/_output/coverage/


### Documentation swagger
Generate the swagger.json file and let nginx serve it :

``` bash
./vendor/bin/swagger src/PartnerBundle/  --output web/swagger.json 
# if you want to modify host and basePath dynamically :
./vendor/bin/swagger src/PartnerBundle/  --stdout | sed 's#"host":.*#"host": "api5.audi.dev.agence-one.net",#;s#"basePath":.*#"basePath": "/partner/api/v1/partner",#' > web/swagger.json
```


### Commands
To setup paiement for partners, we need file contains at least two columns :
* Contract Number : ensure that it's a string format (for the 0 at the begening).
* Payment state : 1 to enable / 0 to disable.

``` bash
bin/console partner:payment:manage [file path] -H (if there has a header)
```
