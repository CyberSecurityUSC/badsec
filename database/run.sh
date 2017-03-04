#!/bin/bash
rm /var/lib/mysql/ran;

if [ ! -f /var/lib/mysql/ran ]; then

	touch /var/lib/mysql/ran;

	mysqld --initialize;
	service mysql start

	echo "create database if not exists injection;" | mysql;
	mysql injection < /scripts/injection.sql;

	echo "create database if not exists requests;" | mysql;
	mysql requests < /scripts/requests.sql;

	echo "create database if not exists jokes;" | mysql;
	mysql jokes < /scripts/jokes.sql;

	echo "create database if not exists dashboard;" | mysql;
	mysql dashboard < /scripts/dashboard.sql;

	echo "create database if not exists blog;" | mysql;
	mysql blog < /scripts/blog.sql;

	# Delete all other users
	mysql mysql < /scripts/secure.sql;

    killall mysqld
    sleep 5s		# kill all and wait.

fi

# /usr/bin/mysqld_safe
service mysql start;
/bin/bash
