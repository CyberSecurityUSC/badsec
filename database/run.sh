#!/bin/bash

if [ ! -f /var/lib/mysql/ibdata1 ]; then

	sudo mysql_install_db
	sudo service mysql start > /dev/null 2> /dev/null; # out kills docker 

	echo "create database if not exists injection;" | sudo mysql;
	sudo mysql injection < /scripts/injection.sql;

	echo "create database if not exists requests;" | sudo mysql;
	sudo mysql requests < /scripts/requests.sql;

	sudo mysql mysql < /scripts/secure.sql;

    killall mysqld
    sleep 30s		# kill all and wait.

fi

/usr/bin/mysqld_safe

