#!/bin/bash
sed -i -e 's/^bind-address.*$/bind-address = 0.0.0.0/g' /etc/mysql/mysql.conf.d/mysqld.cnf

if grep -q -e '^explicit_defaults_for_timestamp.*$' -- /etc/mysql/mysql.conf.d/mysqld.cnf; then
    sed -i -e 's/^explicit_defaults_for_timestamp.*$/explicit_defaults_for_timestamp = 1/g' /etc/mysql/mysql.conf.d/mysqld.cnf
else
    echo 'explicit_defaults_for_timestamp = 1' >> /etc/mysql/mysql.conf.d/mysqld.cnf
fi

systemctl restart mysql

mysql -uroot -ptest -e "CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'test';"
mysql -uroot -ptest -e "GRANT ALL PRIVILEGES ON *.* to 'root'@'%' WITH GRANT OPTION;"
mysql -uroot -ptest -e "FLUSH PRIVILEGES;"
mysql -uroot -ptest -e "CREATE DATABASE IF NOT EXISTS pondo DEFAULT CHARACTER SET = 'utf8mb4' COLLATE = 'utf8mb4_general_ci';"
