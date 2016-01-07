FROM php:7.0-cli
RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/php7.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mv phpredis-php7 /usr/src/php/ext/redis \
    && docker-php-ext-install redis
ADD . /app
