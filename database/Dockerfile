# DOCKER-VERSION 0.3.4
FROM ubuntu:xenial

ENV DEBIAN_FRONTEND noninteractive

# Update twice? Fixes dependency issues.
RUN apt-get -y update
RUN apt-get -y update

RUN apt-get -y install mysql-server mysql-client
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/skip-name-resolve/" /etc/mysql/mysql.conf.d/mysqld.cnf
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/skip-name-resolve/" /etc/mysql/my.cnf
ADD run.sh /bin/run.sh
RUN chmod +x /bin/run.sh
ADD scripts /scripts/

VOLUME ["/var/lib/mysql"]

EXPOSE 3306
