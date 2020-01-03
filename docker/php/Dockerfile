FROM php:7.4-fpm

#xdebug install
RUN pecl install xdebug

#xdebug conf
COPY xdebug.ini /etc/php/7.4/fpm/conf.d/20-xdebug.ini

RUN apt install curl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php --install-dir=/usr/local/bin --filename=composer