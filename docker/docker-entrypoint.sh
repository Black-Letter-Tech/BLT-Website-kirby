#!/bin/sh

# insert values for variables in nginx config and copy to nginx conf.d folder
envsubst '$SERVER_NAME:$VIRTUAL_HOST:$ENABLE_PW' < /docker/nginx/default.conf > /etc/nginx/conf.d/default.conf 

#set ownership for volumes
#kirby needs these dirs writeable by the app
chown -R nobody:nobody public/media
chown -R nobody:nobody public/assets
chown -R nobody:nobody storage
chown -R nobody:nobody content

# Generate Panel-managed custom CSS after the content volume is mounted.
php /docker/generate-site-css.php
chown nobody:nobody public/assets/css/site.css

#install php packages either by running 'composer install' in the container, or uncomment the line below and it will install packages when you run the container
# composer install --no-dev

# run these daemons
# crond
nginx
php-fpm -F
