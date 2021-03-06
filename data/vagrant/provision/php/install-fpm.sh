#!/usr/bin/env bash
add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get install php7.1-fpm php7.1-mysql php7.1-curl php7.1-xml php7.1-xdebug php7.1-mbstring php7.1-bcmath php7.1-gd php7.1-json php7.1-zip php7.1-memcached php7.1-intl php7.1-redis -y

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=bin --filename=composer
php -r "unlink('composer-setup.php');"
