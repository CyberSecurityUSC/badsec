#!/bin/bash
rm /var/lib/mysql/ran;

if [ ! -f /var/lib/mysql/ran ]; then

	touch /var/lib/mysql/ran;

	sudo mysql_install_db
	sudo service mysql start

	echo "create database if not exists injection;" | sudo mysql;
	sudo mysql injection < /scripts/injection.sql;

	echo "create database if not exists requests;" | sudo mysql;
	sudo mysql requests < /scripts/requests.sql;

	echo "create database if not exists jokes;" | sudo mysql;
	sudo mysql jokes < /scripts/jokes.sql;

	echo "create database if not exists dashboard;" | sudo mysql;
	sudo mysql dashboard < /scripts/dashboard.sql;

	echo "create database if not exists blog;" | sudo mysql;
	sudo mysql blog < /scripts/blog.sql;

	# Delete all other users
	sudo mysql mysql < /scripts/secure.sql;

    killall mysqld
    sleep 5s		# kill all and wait.

fi

/usr/bin/mysqld_safe

