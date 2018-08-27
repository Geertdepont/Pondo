#!/usr/bin/env bash
cp /opt/vagrant/apache/ports.conf /etc/apache2/ports.conf
cp /opt/vagrant/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
a2enmod rewrite
a2enmod actions proxy_fcgi alias
a2enconf php7.1-fpm
systemctl restart apache2
