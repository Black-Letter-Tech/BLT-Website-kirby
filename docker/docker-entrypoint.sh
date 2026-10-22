#!/bin/sh

# insert values for variables in nginx config; Alpine nginx includes http.d
envsubst '$SERVER_NAME:$VIRTUAL_HOST:$ENABLE_PW' < /docker/nginx/default.conf > /etc/nginx/http.d/default.conf

#set ownership for volumes
#kirby needs these dirs writeable by the app (php-fpm runs as www-data)
chown -R www-data:www-data public/media
chown -R www-data:www-data public/assets
chown -R www-data:www-data storage
chown -R www-data:www-data content

# Generate Panel-managed custom CSS after the content volume is mounted.
php /docker/generate-site-css.php
chown www-data:www-data public/assets/css/site.css

#install php packages either by running 'composer install' in the container, or uncomment the line below and it will install packages when you run the container
# composer install --no-dev

# run these daemons
# crond
nginx
php-fpm -F
