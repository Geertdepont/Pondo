#!/usr/bin/env bash

sed -ie 's/^;date.timezone =/date.timezone = UTC/g' /etc/php/7.1/cli/php.ini
sed -ie 's/^error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ALL/g' /etc/php/7.1/cli/php.ini
sed -ie 's/^display_errors = Off/display_errors = On/g' /etc/php/7.1/cli/php.ini
sed -ie 's/^display_startup_errors = Off/display_startup_errors = On/g' /etc/php/7.1/cli/php.ini
sed -ie 's/^log_errors = On/log_errors = Off/g' /etc/php/7.1/cli/php.ini
