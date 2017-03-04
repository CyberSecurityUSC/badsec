# DOCKER-VERSION 0.3.4
FROM ubuntu:xenial

ENV DEBIAN_FRONTEND noninteractive

# Update twice? Fixes dependency issues.
RUN apt-get -y update
RUN apt-get -y update
RUN apt-get install -y nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
ADD blog.conf /etc/nginx/blog.conf
RUN apt-get install -y memcached
RUN apt-get -y upgrade
RUN apt-get -y update
ADD server.sh /bin/server
RUN chmod +x /bin/server

RUN mkdir -p /static

VOLUME ["/etc/nginx/sites-enabled"]
EXPOSE 80
