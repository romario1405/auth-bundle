#!/usr/bin/env bash

XDEBUG_ENABLE=0

export XDEBUG_IDE_KEY=${XDEBUG_IDE_KEY:-PHPSTORM}
export XDEBUG_REMOTE_HOST=${XDEBUG_REMOTE_HOST:-127.0.0.1}
export XDEBUG_CLI_ENABLE=${XDEBUG_CLI_ENABLE:-1}

if [[ "$XDEBUG_ENABLE" -eq 1 ]]; then
    cp xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
    cat /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
    alias php=/usr/bin/php
elif [[ -f "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" ]]; then
    rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

    if [[ "$XDEBUG_CLI_ENABLE" -eq 1 ]]; then
        alias xphp='php -z/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xebug.so -dxdebug.remote_enable=1 \
-dxdebug.remote_host="'${XDEBUG_REMOTE_HOST}'" \
-dxdebug.remote_handler=dbgp \
-dxdebug.remote_port=9000 \
-dxdebug.remote_autostart=1 \
-dxdebug.remote_log=/tmp/xdebug.log \
-dxdebug.remote_connect_back=0'

export PHP_IDE_CONFIG="serverName=arango"
    fi
fi
