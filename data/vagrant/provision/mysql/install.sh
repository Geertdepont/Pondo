#!/bin/bash
apt-get update
apt-get upgrade

debconf-set-selections <<< 'mysql-server mysql-server/root_password password test'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password test'

apt-get install -y mysql-server-5.7
