FROM php:8-fpm

RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        dpkg-dev \
        libpng-dev \
        libjpeg-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libzip-dev \
        zip \
        unzip \
        cron

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug,coverage" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.log=/var/www/xdebug.log" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.remote_cookie_expire_time=3600" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.client_host=docker.host.internal" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/20-xdebug.ini
RUN docker-php-ext-configure gd \
  --enable-gd \
  --with-jpeg


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer