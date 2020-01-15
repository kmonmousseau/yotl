#! /bin/bash

chown -R www-data:root /var/www/html/app/cache
chown -R www-data:root /var/www/html/app/logs
chmod 777 /var/www/html/app/cache
chmod 777 /var/www/html/app/logs

/usr/sbin/apache2ctl -D FOREGROUND
