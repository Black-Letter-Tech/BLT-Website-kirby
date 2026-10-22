FROM php:8.4-fpm-bookworm
LABEL org.opencontainers.image.authors="Paul Wagner <paul@oxfordservicesinc.com>"

# Debian base rather than Alpine: the docker host (Docker 19.03,
# kernel 4.4) rejects the newer syscalls current Alpine userlands
# make, which breaks builds and risks runtime failures. Bookworm's
# glibc predates them.

# nginx, build and runtime libraries, tools
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    nginx \
    gettext-base \
    curl \
    apache2-utils \
    imagemagick \
    libicu-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libpng-dev \
    libmagickwand-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) gd intl zip exif opcache && \
    pecl install imagick && \
    docker-php-ext-enable imagick && \
    rm -f /etc/nginx/sites-enabled/default && \
    rm -rf /var/lib/apt/lists/* /tmp/pear

# php.ini: production defaults plus Kirby upload sizes
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    sed -i "s|;*upload_max_filesize =.*|upload_max_filesize = 100M|" /usr/local/etc/php/php.ini && \
    sed -i "s|;*post_max_size =.*|post_max_size = 100M|" /usr/local/etc/php/php.ini

# keep container environment visible to PHP (config.php reads getenv)
RUN { echo '[www]'; echo 'clear_env = no'; } > /usr/local/etc/php-fpm.d/zz-env.conf

# Install composer global bin
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN mkdir /app
WORKDIR /app


COPY ./docker /docker
COPY ./docker/php/00_opcache.ini /usr/local/etc/php/conf.d
RUN chmod +x /docker/docker-entrypoint.sh
COPY ./ /app

#remove stuff we don't need or could be security problems (git repos and password files)
RUN find . -name "*.git" -type d -print0 | xargs -0 /bin/rm -rf

ENV VIRTUAL_HOST=localhost
ENV SERVER_NAME=localhost

#disable pw by default; override with docker-compose
ENV ENABLE_PW=false

ENTRYPOINT ["/docker/docker-entrypoint.sh"]

ENV PORT=80
EXPOSE 80
