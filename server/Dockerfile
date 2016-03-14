# DOCKER-VERSION 0.3.4
FROM ubuntu:trusty

ENV DEBIAN_FRONTEND noninteractive

# Update twice? Fixes dependency issues.
RUN sudo apt-get -y update
RUN sudo apt-get -y update
RUN sudo apt-get install -y nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
ADD blog.conf /etc/nginx/blog.conf
RUN sudo apt-get install -y memcached
RUN sudo apt-get -y upgrade
RUN sudo apt-get -y update
ADD server.sh /bin/server
RUN chmod +x /bin/server

RUN mkdir -p /static

VOLUME ["/etc/nginx/sites-enabled"]
EXPOSE 80