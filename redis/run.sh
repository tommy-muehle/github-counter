#!/usr/bin/env bash

if [ ! -f /.redis_configured ]; then
    echo "requirepass $REDIS_PASS" >> /usr/local/etc/redis/redis.conf
    touch .redis_configured
fi

exec redis-server /usr/local/etc/redis/redis.conf
