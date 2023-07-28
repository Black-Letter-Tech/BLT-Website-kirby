FROM nginx:1.25.0-alpine-slim
MAINTAINER Paul Wagner, paul@oxfordservicesinc.com

#core apk package installs
RUN apk update && \
    apk upgrade && \
    apk add --no-cache --virtual .build-deps\
    php81\
    php81-gd\
    php81-pecl-imagick\
    php81-ctype\
    php81-curl\
    php81-dom\
    php81-json\
    php81-mbstring\
    php81-openssl\
    php81-exif\
    php81-fileinfo\
    php81-intl\
    php81-zip\
    php81-zlib\
    php81-fpm\
    php81-phar\
    php81-simplexml\
    php81-iconv\
    # sometimes debugging is nice
    # php81-pecl-xdebug\
    # required by kirby but docs say these are enabled by default
    # php81-filter\
    # php81-hash\
    # php81-libxml\
    # TODO: get opcache and jit  working https://medium.com/@edouard.courty/make-your-php-8-apps-twice-as-fast-opcache-jit-8d3542276595
    php81-opcache\
    # TODO: check out apcu, memcached and PDO
    # php81-apcu\
    # php81-memcached\
    # php81-PDO\
    # OLD STUFF
    # php81-session\
    # php81-xml\
    # php81-tokenizer\
    # php81-xmlwriter\
    imagemagick\
    curl\
    apache2-utils
    # OLD STUFF
    # rsync\
    # git\
    # openssh-client\

# Small fixes
RUN ln -s /etc/php81 /etc/php && \
    ln -sf /usr/bin/php81 /usr/bin/php && \
    ln -s /usr/sbin/php-fpm81 /usr/bin/php-fpm && \
    ln -s /usr/lib/php81 /usr/lib/php && \
    sed -i "s|;*upload_max_filesize =.*|upload_max_filesize = 100M;|i" /etc/php81/php.ini  && \
    sed -i "s|;*post_max_size =.*|post_max_size = 100M|i" /etc/php81/php.ini  && \
    rm -fr /var/cache/apk/*

# Install composer global bin
RUN curl -sS https://getcomposer.org/installer | php &&\
    mv composer.phar /usr/local/bin/composer

RUN mkdir /app 
WORKDIR /app 


COPY ./docker /docker
COPY ./docker/php/00_opcache.ini /etc/php81/conf.d
# sometimes debugging is nice
# COPY ./docker/php/50_xdebug.ini /etc/php81/conf.d
RUN chmod +x /docker/docker-entrypoint.sh
COPY ./ /app

#remove stuff we don't need or could be security problems (git repos and password files)
RUN find . -name "*.git" -type d -print0 | xargs -0 /bin/rm -rf

ENV VIRTUAL_HOST localhost
ENV SERVER_NAME localhost

#disable pw by default; override with docker-compose
ENV ENABLE_PW "false"

ENTRYPOINT ["/docker/docker-entrypoint.sh"]

ENV PORT 80
EXPOSE 80