#! /bin/bash

chown -R www-data:root /var/www/html/var/cache
chown -R www-data:root /var/www/html/var/logs
chmod 777 /var/www/html/var/cache
chmod 777 /var/www/html/var/logs

/usr/sbin/apache2ctl -D FOREGROUND
