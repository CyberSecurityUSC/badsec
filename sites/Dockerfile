# DOCKER-VERSION 0.3.4
FROM ubuntu:trusty

ENV DEBIAN_FRONTEND noninteractive

RUN sudo apt-get -y update
RUN sudo apt-get install -y wget curl dnsutils libmemcached-dev
RUN wget -O - http://dl.hhvm.com/conf/hhvm.gpg.key | sudo apt-key add -
RUN echo deb http://dl.hhvm.com/ubuntu trusty main | sudo tee /etc/apt/sources.list.d/hhvm.list
RUN sudo apt-get -y update
RUN sudo apt-get install -y hhvm

ADD scripts/ scripts/
RUN chmod -R 700 /scripts/

RUN useradd -ms /bin/bash notroot

VOLUME ["/sites"]
EXPOSE 1337
