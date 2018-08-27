#!/usr/bin/env bash
sed -i -e 's/^;date.timezone =/date.timezone = UTC/g' /etc/php/7.1/fpm/php.ini
sed -i -e 's/^error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ALL/g' /etc/php/7.1/fpm/php.ini
sed -i -e 's/^display_errors = Off/display_errors = On/g' /etc/php/7.1/fpm/php.ini
sed -i -e 's/^display_startup_errors = Off/display_startup_errors = On/g' /etc/php/7.1/fpm/php.ini
sed -i -e 's/^log_errors = On/log_errors = Off/g' /etc/php/7.1/fpm/php.ini
systemctl restart php7.1-fpm
