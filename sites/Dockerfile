# DOCKER-VERSION 0.3.4
FROM ubuntu:trusty

ENV DEBIAN_FRONTEND noninteractive

RUN sudo apt-get -y update
RUN sudo apt-get install -y wget curl dnsutils libmemcached-dev
RUN wget -O - http://dl.hhvm.com/conf/hhvm.gpg.key | sudo apt-key add -
RUN echo deb http://dl.hhvm.com/ubuntu trusty main | sudo tee /etc/apt/sources.list.d/hhvm.list
RUN sudo apt-get -y update
RUN sudo apt-get install -y hhvm
RUN sudo apt-get install -y ssh
RUN sudo apt-get install -y git

ADD scripts/ /scripts/
RUN chmod -R 700 /scripts/

# Set up ssh
RUN useradd -ms /bin/bash notroot
RUN mkdir -p /home/notroot/.ssh
ADD provisioning/sshd_config /etc/ssh/sshd_config
RUN chown -R notroot /home/notroot/
RUN chgrp -R notroot /home/notroot/
RUN chmod -R 700 /home/notroot/.ssh
ADD provisioning/key.pub /home/notroot/.ssh/authorized_keys
RUN chmod -R 000 /home/notroot/.ssh/authorized_keys

# Fix locale for hhvm
RUN echo LC_CTYPE="en_US.UTF-8" >> /etc/default/locale
RUN echo LC_ALL="en_US.UTF-8"   >> /etc/default/locale

VOLUME ["/sites"]
EXPOSE 1337
EXPOSE 7331
