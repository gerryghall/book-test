FROM php:5.6-apache

MAINTAINER Gerry G Hall

# PHP extension
RUN requirements="zlib1g-dev libicu-dev git curl" \
    && apt-get update && apt-get install -y $requirements && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install intl \
    && apt-get purge --auto-remove -y

# Apache & PHP configuration
RUN a2enmod rewrite

ADD ./docker/apache/bookstore.conf /etc/apache2/sites-enabled/000-default.conf
ADD ./docker/php/php.ini /usr/local/etc/php/php.ini

# Add the application
ADD ./www /var/www/bookstore

# Add Simple DataStore
ADD ./data /var/www/data

RUN chown www-data -R /var/www/bookstore
RUN chown www-data -R /var/www/data

EXPOSE 80
CMD /usr/sbin/apache2ctl -D FOREGROUND