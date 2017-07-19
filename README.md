# audi-agc5-partner

## Configuration Supervisor pour injection des données myAudi
```
[program:rabbitmq-audi-user-update-partner]
command=/var/www/audi-agc5-partner/bin/console rabbitmq:consumer myaudi_user_create_or_update_partner
stdout_logfile=/var/log/supervisor/%(program_name)s.log
stderr_logfile=/var/log/supervisor/%(program_name)s.log
autostart=true
```
